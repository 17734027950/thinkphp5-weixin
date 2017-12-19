<?php
namespace app\api\controller\v1;
use app\api\controller\v1\BaseController;
use app\api\validate\Order as OrderValidate;
use think\Validate;

class Order extends BaseController{
    //处理订单
    protected $beforeActionList = [
        'checkExclusiveScope'=>['only'=>'placeOrder'],
        'checkPrimaryScope'=>['only'=>'getOrderDetailById','getSummaryByUser']
    ];
    /**
     * @return array
     * 下单接口
     */
    public function placeOrder(){
        (new OrderValidate())->goCheck();
    }
}