<?php
namespace app\api\validate;
use app\api\validate\BaseValidate;

class IDMustBePostiveInt extends BaseValidate{
    protected $rule = [
        'id' => 'require|checkID'
    ];
    protected $message = [
        'id' => 'id必须是正整数'
    ];
    public function checkID($id){
       if($this->isPositiveInt($id)){
            return true;
       }else{
           return false;
       }
    }
}