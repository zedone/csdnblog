<?php
namespace app\home\model;
use \think\Model;
use app\home\model\Base;

class Blog extends Base
{
    public $table = 'blog';
    	//获取全部博客
    public function blogLists(){
    	$lists = $this->select();
    	$tmp = [];
    	foreach ($lists as $key => $value) {
    		$tmp[] = $value->toArray();
    	}
    	return $tmp;
    }

}
