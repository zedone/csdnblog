<?php
namespace app\index\model;
use think\Db;
use think\Model;
use Cache\Cache;
/**
 * 
 */
class User extends Model
{
	
	public function userLogin($data) {
		$res=[];
		$phone=$this->where('phone',$data)->select();
		// var_dump($phone);die;
		foreach ($phone as $key => $value) {
			$res[$value['phone']]=$value->toArray();
		}
		return $res;
	}
	public function addUser($data){
		if($this->save($data)) {
			return true;
		}else{
			return false;
		}
	}
	public function checkPhone($data){
		$phone=$this->where('phone',$data)->select();
		if (!empty($phone)) {
			return false;
		}else{
			return true;
		}
	}
}