<?php
namespace app\api\model;
use app\api\model\BaseModel;

class User extends BaseModel{
    public static function getByOpenID($openid){
        $result = self::get(['openid'=>$openid]);
        return $result;
    }
}