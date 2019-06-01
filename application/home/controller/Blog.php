<?php
namespace app\home\controller;
use think\Controller;
use app\home\model\Blog as BlogModel;
class Blog extends Controller
{
    public function index(){
    	$indexModel = new BlogModel;
    	$blogList = $indexModel->blogLists();
    	dump($blogList);die;
    	//sendJson($errorno,$msg,$data);
    }
}
