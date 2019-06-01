<?php

namespace app\home\controller;

 use \think\Controller;
 use \app\home\model\User as UserModel;
 /**
  * 
  */
 class User extends Controller
 {

    public function doReg(){
        $errorno    = 0;
        $msg        = '成功';
        $data       = [];
        $post_data  = input('post.');
        if (empty($post_data)) {
            $errorno    = 1;
            $msg        = 'post为空';
            sendJson($errorno,$msg,$data);die();
        }

        if (empty($post_data['name'])||empty($post_data['phone'])||empty($post_data['password'])) {
            $errorno    = 2;
            $msg        = '缺少必要参数';
            sendJson($errorno,$msg,$data);die();
        }
        $phone = $post_data['phone'];
        $str_len    = strlen($post_data['phone']);

        if ($str_len != 11) {
            $errorno    = 3;
            $msg        = '电话号不符合规范';
            sendJson($errorno,$msg,$data);die();           
        }

        $user_obj   = new UserModel;
        $result     = $user_obj->getinfo('phone',$phone);
        if ($result) {
            $errorno    = 4;
            $msg        = '电话号已被使用';
            sendJson($errorno,$msg,$data);die(); 
        }

        $time       = time();

        $tmp_data = [
            'name'           => $post_data['name'],
            'phone'          => $phone,
            'password'       => $post_data['password'],
            'status'         => 1,
            'create_time'    => $time,
            'update_time'    => $time,
        ];
        $result     = $user_obj-> add($tmp_data);
        if (!$result) {
            $errorno    = 5;
            $msg        = '插入失败';
            sendJson($errorno,$msg);die();
        }

        sendJson();die();

    }  

 }