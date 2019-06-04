<?php
namespace app\home\model;

use \think\Db;
use \think\Model;
use \think\Collection;
use \think\File;
/**
 * 
 */
class Base extends Model
{   
    public function add($data){
        $result = $this->insert($data);

        return $result;
    }

    public function addGetId($data){
        $result = $this->insertGetId($data);
        return $result;
    }
    public function updateField($field1,$info,$field2,$data){
        $result=$this->where($field1,$info)->limit(1)->setField($field2, $data);
        return $result;
    }

    public function getInfo($field,$value){
        $info = $this->where($field,$value)->limit(1)->find();
        if ($info) {
            $info = $info->toArray();
        }
        if(!$info){
            return [];
        }
        return $info;
    }
    public function selectInfo($field,$value,$offset=0,$limit=10){
        $info =$this->where($field,$value)->limit($offset,$limit)->select();
        if ($info) {
            $info = lists_to_array($info);
        }
        return $info;
    }

    public function getLists($offset=0,$limit=10){

        $lists = $this->limit($offset,$limit)->select();
        if ($lists) {
            $result =lists_to_array($lists);
        }else{
            $result = false;
        }
        return $result;
    }

    public function getListsAll(){

        $lists = $this->select();
        if ($lists) {
            $result =lists_to_array($lists);
        }else{
            $result = false;
        }
        return $result;
    }

    public function changeLists(){
        $result=self::getLists();
        $umsg=get_key_value($result,'id');
        return $umsg;
    }

    public function changeListsAll(){
        $result=self::getListsAll();
        if (!$result) {
            return [];
        }
        $umsg=get_key_value($result,'id');
        return $umsg;
    }
    
    public function doupdate($id,$data){
        $result = $this->where('id', $id)->limit(1)->update($data);
        return $result;
    }

    public function dodelete($field,$value){
        $result = $this->where($field,$value)->limit(1)->delete();
        return $result;
    }
}
