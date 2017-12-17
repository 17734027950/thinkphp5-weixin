<?php
namespace app\lib\exception;
use app\lib\exception\BaseException;

class ProductException extends BaseException{
    public $code = 404;
    public $msg = '请求的产品不存在';
    public $errorCode = 30001;
}