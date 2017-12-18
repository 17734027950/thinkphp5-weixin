<?php
namespace app\lib\exception;
use app\lib\exception\BaseException;

class SuccessMessage{
    public $code = 200;
    public $msg = 'OK';
    public $errorCode = 0;
}