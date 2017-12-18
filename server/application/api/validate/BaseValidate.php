<?php
namespace app\api\validate;
use think\Validate;
use think\Loader;
use think\Exception;
use app\lib\exception\ParameterException;
use app\lib\exception\AddressException;

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
    /**
     * 验证参数是否为手机号码
     * @param int $value
     * @return boolean
     */
    protected function isMobile($value, $rule = '', $data = '', $filed = ''){
        $pattern = '/^1(3|4|5|6|7|8|9)\d{9}$/';
        if (preg_match($pattern, $value)) {
            return true;
        }else{
            return false;
        }
    }
    /**
     * 验证参数是否包含非法键值
     * @param int $value
     * @return boolean
     */
    public function isParamLegal($value, $rule = '', $data = '', $filed = ''){
        foreach($value as $k=>$v){
            if(!array_key_exists($k, $this->rule)){
                throw new ParameterException([
                    'msg'=>'参数中包含非法键值对'
                ]);
            }
        }
        return true;
    }
}