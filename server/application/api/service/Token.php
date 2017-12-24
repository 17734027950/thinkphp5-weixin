<?php
namespace app\api\service;

use think\Exception;
use app\lib\exception\ParameterException;
use app\lib\exception\ForbidException;
use app\lib\enum\ScopeEnum;

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
    //获取uid
    public static function getUid(){
        $cacheValue = self::getCache();
        return $cacheValue['uid'];
    }
    //获取scope
    public static function getScope(){
        $cacheValue = self::getCache();
        return $cacheValue['scope'];
    }
    //获取缓存
    public static function getCache(){
        $token = request()->header('token');
        if($token){
            $cacheValue = cache($token);
            if(!$cacheValue){
                throw new Exception('获取缓存失败');
            }else{
                if(!is_array($cacheValue)){
                    $cacheValue = json_decode($cacheValue, true);
                }
                return $cacheValue;
            }
        }else{
            throw new ParameterException([
                'msg'=>'token不能为空'
            ]);
        }
    }
    /**
     * @return bool
     * @throws ForbidException
     * @throws TokenException
     * 检查基本的权限，用户和cms管理员都可以访问
     */
    public static function needPrimaryScope() {
        $scope = self::getScope();
        if($scope){
            if($scope >= ScopeEnum::USER){
                return true;
            }else{
                throw new ForbidException();
            }
        }
    }
    /**
     * @return bool
     * @throws ForbidException
     * @throws TokenException
     * 只有用户才可以访问的权限
     */
    public static function needExclusiveScope() {
        $scope = self::getScope();
        if($scope){
            if($scope == ScopeEnum::USER){
                return true;
            }else{
                throw new ForbidException();
            }
        }
    }
    /**
     * 检测当前用户是否为该订单的用户
     * @param int $uid
     * @return bool
     */
    public static function isValidOperate($uid){
        if(!$uid){
            throw new Exception('用户不存在');
        }
        $cacheValue = self::getCache();
        $current_uid = $cacheValue['uid'];
        if($uid != $current_uid){
            throw new ParameterException([
                'msg'=>'用户名和订单不匹配'
            ]);
        }
        return true;
    }
}
