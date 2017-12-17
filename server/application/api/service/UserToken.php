<?php
namespace app\api\service;
use app\lib\exception\WechatException;
use app\api\model\User as UserModel;
use app\api\service\Token;

class UserToken extends Token{
    protected $app_id;
    protected $app_secret;
    protected $login_url;
    protected $code;

    public function __construct($code){
        $this->code = $code;
        $this->app_id = config('wx.app_id');
        $this->app_secret = config('wx.app_secret');
        $this->login_url = sprintf(config('wx.login_url'), $this->app_id, $this->app_secret, $code);
    }
    /**
     * @return string
     * @throws Exception
     * 获取令牌
     */
    public function get(){
        $result = curl_get($this->login_url);
        $result = json_decode($result, true);
        if(empty($result)){
            throw new Exception('获取session_key和openid异常，微信内部错误');
        }else{
            if(array_key_exists('errcode', $result)){
                $this->processLoginError($result);
            }else{
                return $this->grantToken($result);
            }
        }
    }
    /**
     * @param $wxresult
     * @return string
     * 分配令牌
     */
    private function grantToken($data){
        //拿到openid
        //数据库里面看一下这个openid是否存在，如果存在则不处理，不存在则新增加一条user记录
        //生成令牌，准备缓存数据，写入缓存
        //把令牌返回到客户端
        //key 令牌
        //value wxresult,$uid,scope
        $openid = $data['openid'];
        $result = UserModel::getByOpenID($openid);
        if($result){
            $uid = $result->id;
        }else{
            $uid = $this->newUser($openid);
        }
        $cacheValue = $this->prepareCacheValue($data,$uid);
        return $this->saveToCache($cacheValue);
    }
    /**
     * @param $cacheValue
     * @return string
     * @throws TokenException
     * 把令牌信息和用户信息写入缓存
     */
    private function saveToCache($cacheValue) {
        $key = self::generateToken();
        //json_encode 可以把数组转化成字符串
        $value =json_encode($cacheValue);
        $expire_in = config('setting.token_expire_in');
        $cache = cache($key,$value,$expire_in);
        if(!$cache) {
            throw new TokenException([
                'msg'=>'服务器缓存异常',
                'errorCode'=>10005
            ]);
        }else {
            return $key;
        }

    }
    /**
     * @param $wxresult
     * @param $uid
     * @return mixed
     * 准备缓存数据
     */
    private function prepareCacheValue($wxresult,$uid) {
        $CacheValue = $wxresult;
        $CacheValue['uid'] = $uid;
        //16 普通用户 32 super用户 枚举类型
        //$CacheValue['scope'] = ScopeEnum::user;
        return $CacheValue;
    }
    /**
     * @param $openid
     * @return mixed
     * 创建新用户
     */
    private function newUser($openid){
        $user = UserModel::create([
                'openid'=>$openid
            ]);
        return $user->id;
    }
    /**
     * @param $wxresult
     * @throws WxChatException
     * 处理微信登录错误
     */
    private function processLoginError($data){
        throw new WechatException([
            'msg'=>$data['errmsg'],
            'errorCode'=>$data['errcode']
        ]);
    }
}