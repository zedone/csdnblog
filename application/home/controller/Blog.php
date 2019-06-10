<?php
namespace app\home\controller;
use app\model\blog as BlogModel;
use app\model\classify as ClassifyModel;
use app\model\token as TokenModel;
use app\model\message as MessageModel;
/**
 * 
 */
class Blog
{
    public function index(){
        $blogModel = new BlogModel;
        $blogList = $blogModel->blogLists();
        //var_dump($blogList);die;
        $format = $blogModel->formatBlog($blogList);

        $classify = new ClassifyModel;
        $classifyRes = $classify->getInfoClassify($format['classify_id']);
        $format['classify_name'] = $classifyRes['name'];
        sendJson(0,'ok',$format);
    }

    public function detail(){
        $id = input('id');
        if(empty($id)){
            sendJson(1,'参数错误',[]);
        }
        $blogModel = new BlogModel;
        $soleBlog = $blogModel->getInfo('id',$id);
        if(empty($soleBlog)){
            sendJson(2,'暂无数据',[]);
        }
        $classify = new ClassifyModel;
        $classifyRes = $classify->getInfoClassify($soleBlog['classify_id']);
        $soleBlog['classify_name'] = $classifyRes['name'];
        $message = new MessageModel;
        $messageRes = $message->messageLists($id);
        if(empty($messageRes)){
            sendJson(2,'暂无数据',[]);
        }
        $messageData = $message->formatMessage($messageRes);
        $soleBlog['comment'] = $messageData;
        sendJson(0,'ok',$soleBlog);
    }
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

