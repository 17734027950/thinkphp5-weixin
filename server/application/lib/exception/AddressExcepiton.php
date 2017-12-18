<?php
namespace app\lib\exception;
use app\lib\exception\BaseException;

class AddressException extends BaseException{
    public $code = 400;
    public $msg = '请求参数中不能包含非法键值';
    public $errorCode = 10000;
}