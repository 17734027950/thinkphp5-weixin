<?php
namespace app\api\validate;

use app\api\validate\BaseValidate;

class IDMustBeArray extends BaseValidate{
    protected $rule = [
        'ids'=>'require|checkIds'
    ];
    protected $message = [
        'ids'=>'id必须是正整数'
    ];
    public function checkIds($ids){
        $arr = explode(',', $ids);
        foreach($arr as $id){
            if(!$this->isPositiveInt($id)){
                return false;
            }
        }
        return true;
    }
}