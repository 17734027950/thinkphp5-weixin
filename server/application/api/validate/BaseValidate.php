<?php
namespace app\api\validate;
use think\Validate;
use think\Loader;
use think\Exception;
use app\lib\exception\ParameterException;

class BaseValidate extends Validate{
    /**
     * 验证器
     */
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
    /**
     * 验证参数是否为正整数
     * @param int $value
     * @return boolean
     */
    protected function isPositiveInt($value, $rule = '', $data = '', $filed = ''){
        if (is_numeric($value) && is_int($value + 0) && ($value + 0) > 0) {
            return true;
        }else{
            return false;
        }
    }
    /**
     * 验证参数是否为空
     * @param int $value
     * @return boolean
     */
    protected function isNotEmpty($value, $rule = '', $data = '', $filed = ''){
        if (!empty($value)) {
            return true;
        }else{
            return false;
        }
    }
}