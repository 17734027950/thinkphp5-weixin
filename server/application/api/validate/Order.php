<?php
namespace app\api\validate;
use app\api\validate\BaseValidate;
use app\lib\exception\ProductException;
use app\lib\exception\ParameterException;

class Order extends BaseValidate{
    protected $rule = [
        'products'=>'require|checkProducts'
    ];
    //验证参数合法行
    protected $singleRule = [
        'product_id'=>'require|isPositiveInt',
        'count'=>'require|isPositiveInt'
    ];
    //检测产品是否为数组
    protected function checkProducts($products){
        if(!is_array($products)){
            throw new ParameterException([
                'msg'=>'参数不合法'
            ]);
        }
        if(empty($products)){
            throw new ParameterException([
                'msg'=>'商品列表不能为空'
            ]);
        }
        foreach($products as $v){
            $this->checkProduct($v);
        }
        return true;
    }
    private function checkProduct($product){
        $validate = new BaseValidate($this->singleRule);
        $result = $validate->check($product);
        if(!$result){
            throw new ParameterException([
                'msg'=>'产品id='.$product['product_id'].'参数错误'
            ]);
        }
    }
}