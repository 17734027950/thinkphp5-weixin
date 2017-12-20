<?php
namespace app\api\validate;
use app\api\validate\BaseValidate;

class PageParameter extends BaseValidate{
    protected $rule = [
        'size'=>'require|isPositiveInt',
        'page'=>'require|isPositiveInt',
    ];
}