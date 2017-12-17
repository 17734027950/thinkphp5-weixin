<?php
namespace app\lib\exception;

use app\lib\exception\BaseException;

class ThemeMissException extends BaseException{
    public $code = 404;
    public $errorCode = 30000;
    public $msg = '请求的主题不存在';
}