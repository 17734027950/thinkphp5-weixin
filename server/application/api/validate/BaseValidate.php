<?php
namespace app\api\validate;
use think\Validate;
use think\Exception;
use app\lib\exception\ParameterException;

class BaseValidate extends Validate{
    public function goCheck(){
        $data = input('');
        $re = $this->batch()->check($data);
        if(!$re){
            $e = new ParameterException([
                'msg'=>$this->error
            ]);
            throw $e;
        }else{
            return true;
        }
    }
}