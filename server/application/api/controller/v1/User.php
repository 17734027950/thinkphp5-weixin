<?php
namespace app\api\controller\v1;
use app\api\controller\v1\BaseController;
use app\api\validate\CodeGet;
use app\api\service\UserToken;

class User extends BaseController{
    public function getToken(){
        (new CodeGet())->goCheck();
        $code = input('post.code');
        $ut = new UserToken($code);
        $token = $ut->get();
        return [
            'token'=>$token
        ];
    }
}