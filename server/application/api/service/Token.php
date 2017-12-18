<?php
namespace app\api\service;

use think\Exception;

class Token
{
    /**
     * @return string
     * 形成随机token
     */
    public static function generateToken() {
        //32个随机组成的随机字符串
        $randChars = getRandChars(32);
        $timestamp = $_SERVER['REQUEST_TIME'];
        $salt = config('secure.token_salt');
        return md5($randChars.$timestamp.$salt);
    }
    public static function getUid(){
        $token = request()->header('token');
        $cacheValue = cache($token);
        if(!$cacheValue){
            throw new Exception('获取缓存失败');
        }else{
            if(!is_array($cacheValue)){
                $cacheValue = json_decode($cacheValue, true);
            }
            return $cacheValue['uid'];
        }
    }
}