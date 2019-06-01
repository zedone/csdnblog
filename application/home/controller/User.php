<?php

namespace app\home\controller;

 use \think\Controller;
 use \app\home\model\User as UserModel;
 use \app\home\model\Token as TokenModel;
 use \app\home\model\Blog as BlogModel;
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
        $result     = $user_obj->getInfo('phone',$phone);

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

    public function saveBlog(){
        $errorno    = 0;
        $msg        = '成功';
        $data       = [];
        $post_data  = input('post.');

        if (empty($post_data)) {
            $errorno    = 1;
            $msg        = 'post为空';
            sendJson($errorno,$msg,$data);die();
        }
        $token      = !empty($post_data['token'])?$post_data['token']:'';
        $token_obj  = new TokenModel;
        $result      = $token_obj->getUserInfo($token);

        if (!$result) {
            $errorno    = 2;
            $msg        = 'token不存在或失效';
            sendJson($errorno,$msg,$data);die();            
        }
        $user_id        = $result['value']['id'];

//id,title,classify_id,content,status,create_time,update_time
        $title          = !empty($post_data['title'])?$post_data['title']:'';
        $classify_id    = !empty($post_data['classify_id'])?$post_data['classify_id']:0;
        $content        = !empty($post_data['content'])?$post_data['content']:'';

        $time =time();
        $tmp_data = [
            'user_id'       => $user_id,
            'title'         => $title,
            'classify_id'   => $classify_id,
            'content'       => $content,
            'status'        => 1,
            'create_time'   => $time,
            'update_time'   => $time,
        ];        
        
        $blog_obj   = new BlogModel;
        $result     = $blog_obj-> add($tmp_data);

        if (!$result) {
            $errorno    = 5;
            $msg        = '插入失败';
            sendJson($errorno,$msg);die();
        }

        sendJson();die();     
    }

    public function blogList(){
        $errorno    = 0;
        $msg        = '成功';
        $data       = [];
        $post_data  = input('post.');

        if (empty($post_data)) {
            $errorno    = 1;
            $msg        = 'post为空';
            sendJson($errorno,$msg,$data);die();
        }

        $token      = !empty($post_data['token'])?$post_data['token']:'';
        $token_obj  = new TokenModel;
        $result      = $token_obj->getUserInfo($token);

        if (!$result) {
            $errorno    = 2;
            $msg        = 'token不存在或失效';
            sendJson($errorno,$msg,$data);die();            
        }
        $user_id        = $result['value']['id'];

        $blog_obj   = new BlogModel;
        $result     = $blog_obj->selectInfo('user_id',$user_id);

        $classify_obj   = new ClassifyModel;
        $class_info     = $classify_obj->getInfo('id',$result['classify_id']);
        $class_name     = !empty($class_info['name'])?$class_info['name']:'';

        $data       = [
            'classify_id'   => $result['classify_id'],
            'class_name'    => $class_name,
            'title'         => $result['title'],
            'content'       => $result['content'],
        ];

        if (!$result) {
            $errorno    = 3;
            $msg        = '查询失败';
            sendJson($errorno,$msg);die();
        }

        sendJson($errorno,$msg,$data);die();         
    }
 }