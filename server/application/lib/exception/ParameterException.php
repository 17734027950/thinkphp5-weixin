<?php
namespace app\lib\exception;
use app\lib\exception\BaseException;

class ParameterException extends BaseException{
    public $code = 400;
    public $msg = '请求参数错误';
    public $errorCode = 10000;
}