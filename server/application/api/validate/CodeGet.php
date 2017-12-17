<?php
namespace app\api\validate;

use app\api\validate\BaseValidate;

class CodeGet extends BaseValidate{
    protected $rule = [
        'code'=>'require|isNotEmpty'
    ];
    protected $message = [
        'code'=>'code不能为空'
    ];
}