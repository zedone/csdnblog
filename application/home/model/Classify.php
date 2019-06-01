<?php
namespace app\home\model;
use think\Model;
use think\Db;
class Classify extends Base{
    public function getInfoClassify($classid){
        return $this->where('id',$classid)->find()->toArray();
    }
}
