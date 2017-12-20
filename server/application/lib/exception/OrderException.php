<?php
namespace app\lib\exception;
use app\lib\exception\BaseException;

class OrderException extends BaseException{
    public $code = 404;

    public $msg = '商品不存在';

    public $errorCode = 60001;
}