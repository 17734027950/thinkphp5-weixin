<?php
namespace app\lib\exception;
use app\lib\exception\BaseException;

class ForbidException extends BaseException{
    public $code = 403;
    public $msg = '没有权限访问';
    public $errorCode = 40000;
}