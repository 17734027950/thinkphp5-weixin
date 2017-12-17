<?php
namespace app\lib\exception;

use app\lib\exception\BaseException;

class WechatException extends BaseException{
    public $code = 400;
    public $errorCode = 50000;
    public $msg = '微信内部错误';
}