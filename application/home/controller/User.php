<?php
namespace app\home\controller;
use app\home\model\User as UserModel;
/**
 * 
 */
class User
{
	public function doLogin(){
		
	}
	public function doReg(){
		$data = input('post.');
		$name = $data['name'];
		$phone = $data['phone'];
		$password = $data['password'];
		$userList = new UserModel;
		$check = checkPhone($phone);
		$result=[
				'error' = 0,
				'msg' = "",
				'data' = '',
			]
		if($check){
			$result['msg']="电话已被用";
			$result['error']=1;
			return json_encode($result);die;
		}
		if (empty($data)) {
			$result=[
				'error' = 1,
				'msg' = "没有数据",
				'data' = '',
			]
			return json_encode($result);die;
		}
		if(empty($name)||empty($phone)||empty($password)){
			$result=[
				'error' = 1,
				'msg' = "没有数据",
				'data' = '',
			]
			return json_encode($result);die;
		}
		$data['status']=1;
		$info = $userList->addUser($data);
		if ($info) {
			$result['msg']="注册成功";
			return json_encode($result);die;
		}else{
			$result=[
				'error' = 1,
				'msg' = "注册失败",
				'data' = '',
			]
			return json_encode($result);die;
		}
	}
	public function saveBlog(){
		
	}
	public function blogList(){
		
	}
}