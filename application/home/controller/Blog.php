<?php
namespace app\home\controller;
/**
 * 
 */
class Blog
{
	public function message(){
        $errorno    = 0;
        $msg        = '成功';
        $data       = [];
        $post_data  = input('post.');
        $get_data  = input('get.');
        if (empty($post_data)) {
            $errorno    = 1;
            $msg        = 'post为空';
            sendJson($errorno,$msg,$data);die();
        }
        $token      = !empty($post_data['token'])?$post_data['token']:'';
        if (empty($token)) {
            $errorno    = 1;
            $msg        = '请登录';
            sendJson($errorno,$msg,$data);die();
        }
        $token_obj  = new TokenModel;
        $result      = $token_obj->getUserInfo($token);

        if (!$result) {
            $errorno    = 2;
            $msg        = 'token不存在或失效';
            sendJson($errorno,$msg,$data);die();            
        }
        $user_id        = $result['value']['id'];
        $blog_id         = !empty($get_data['blog_id '])?$get_data['blog_id ']:'';
        if (empty($blog_id)) {
            $errorno    = 1;
            $msg        = '没有此博客';
            sendJson($errorno,$msg,$data);die();
        }
        $info = [
            'user_id' => $user_id,
            'blog_id' => $blog_id,
            'content' => $post_data['content'],
        ];
        $messsage_obj  = new MessageModel;
        $result     = $message_obj-> add($info);
        if (!$result) {
            $errorno    = 5;
            $msg        = '插入失败';
            sendJson($errorno,$msg);die();
        }

        sendJson();die();
    } 
}