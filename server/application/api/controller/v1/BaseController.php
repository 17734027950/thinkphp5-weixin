<?php
namespace app\api\controller\v1;
use think\Controller;
use think\Request;
use app\api\service\Token;

class BaseController extends Controller{
    public function __contructor(Request $request=null){

    }
    //只有用户才可以访问的权限
    protected function checkExclusiveScope(){
        return Token::needExclusiveScope();
    }
    //检查基本的权限，用户和cms管理员都可以访问
    protected function checkPrimaryScope(){
        return Token::needPrimaryScope();
    }
}