<?php
namespace app\home\model;
use \think\Model;
use app\home\model\Base;

class Message extends Base
{
    public $table = 'message';
    	//获取全部博客
    public function messageLists($where){
    	$lists = $this->where('blog_id',$where)->select();
    	$tmp = [];
    	foreach ($lists as $key => $value) {
    		$tmp[] = $value->toArray();
    	}
    	return $tmp;
    }

    public function formatMessage($blogLists){
        $result = [];
        foreach ($blogLists as $key => $value) {
            $result[] = [
                'user_img'          => $value['user_img'],
                'content'           => $value['title'],
                'create_time'       => $value['create_time'],
            ];
        }
        return $result;
    }

}
