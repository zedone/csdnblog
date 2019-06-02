<?php
namespace app\home\controller;
use think\Controller;
use app\home\model\Blog as BlogModel;
use app\home\model\Classify;
class Blog extends Controller
{
    public function index(){
    	$indexModel = new BlogModel;
    	$blogList = $indexModel->blogLists();
    	//dump($blogList);die;
    	sendJson(0,'ok',$blogList);
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
        $classify = new Classify;
       // dump($soleBlog['classify_id']);die;
        $classifyRes = $classify->getInfoClassify($soleBlog['classify_id']);
        $soleBlog['classify_name'] = $classifyRes['name'];
    	//dump($soleBlog);die;
    	sendJson(0,'ok',$soleBlog);
    }
}
