<?php
namespace app\home\controller;
use think\Controller;
use app\home\model\Blog as BlogModel;
use app\home\model\Classify as ClassifyModel;
use \app\home\model\Token as TokenModel;
use \app\home\model\Message as MessageModel;
class Blog extends Controller
{
    public function index(){
    	$blogModel = new BlogModel;
    	$blogList = $blogModel->blogLists();
    	//var_dump($blogList);die;
        $format = $blogModel->formatBlog($blogList);
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
       // dump($soleBlog['classify_id']);die;
        $classifyRes = $classify->getInfoClassify($soleBlog['classify_id']);
        $soleBlog['classify_name'] = $classifyRes['name'];
    	//dump($soleBlog);die;
        $message_obj = new MessageModel;
        $messageRes = $message_obj->messageLists($id);
        $messageData = $message_obj->formatMessage($messageRes);
        $soleBlog['message'] = $messageData;
    	sendJson(0,'ok',$soleBlog);
    }

    public function getBlogBySort(){
        $classify_id = input('post.classify_id');
        if(empty($classify_id)){
            sendJson(1,'参数错误',[]);
        }
        $blog_obj = new BlogModel;
        $sort_blog = $blog_obj->selectInfo('classify_id',$classify_id);
        if(empty($sort_blog)){
            sendJson(2,'暂无数据',[]);
        }
        sendJson(0,'ok',$sort_blog);
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
