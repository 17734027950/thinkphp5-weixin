<?php
namespace app\api\controller\v1;
use app\api\controller\v1\BaseController;
use app\api\validate\CodeGet;
use app\api\service\UserToken;

class User extends BaseController{
    public function getToken($code=''){
        (new CodeGet())->goCheck();
        $ut = new UserToken($code);
        $token = $ut->get();
        return [
            'token'=>$token
        ];
    }
}