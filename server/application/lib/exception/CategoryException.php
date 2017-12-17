<?php
namespace app\lib\exception;
use app\lib\exception\BaseException;

class CategoryException extends BaseException{
    public $code = 404;
    public $errorCode = 3000;
    public $msg = '请求的分类不存在';
}