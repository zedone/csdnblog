<?php
namespace app\home\model;
use think\Model;
class Blog extends Model
{
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
