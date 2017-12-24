<?php
namespace app\api\controller\v1;
use app\api\controller\v1\BaseController;
use app\api\validate\Order as OrderValidate;
use think\Validate;
use app\api\service\Token;
use app\api\service\Order as OrderService;
use app\api\model\Order as OrderModel;
use app\lib\exception\OrderException;
use app\api\validate\PageParameter;
use app\api\validate\IDMustBePositiveInt;

class Order extends BaseController{
    //处理订单
    protected $beforeActionList = [
        'checkExclusiveScope'=>['only'=>'placeOrder'],
        'checkPrimaryScope'=>['only'=>'getDetailById','getSummaryByUser']
    ];
    /**
     * @return array
     * 下单接口
     */
    public function placeOrder(){
        (new OrderValidate())->goCheck();
        $uid = Token::getUid();
        $products = input('post.products/a');
        $order = new OrderService();
        $status = $order->place($uid, $products);
        return $status;
    }
    /**
     * 获取订单的简要信息
     * @param int $size
     * @param int $page
     * @return array
     */
    public function getSummary($size=10, $page=1){
        (new PageParameter())->goCheck();
        $result = OrderModel::getSummary($size, $page);
        $currentPage = $result->currentPage();
        $totalPage = $result->total();
        if($result->isEmpty()){
            return [
                'data'=>[],
                'current_page'=>$currentPage
            ];
        }
        $result = $result->hidden(['snap_items','snap_address','prepay_id'])->toArray();
        return [
            'data'=>$result,
            'current_page'=>$currentPage,
            'total_page'=>$totalPage
        ];
    }
    /**
     * 根据用户获取订单信息
     * @param int $size
     * @param int $page
     */
    public function getSummaryByUser($size=10, $page=1){
        (new PageParameter())->goCheck();
        $uid = Token::getUid();
        $result = OrderModel::getOrderByUser($uid, $size, $page);
        $currentPage = $result->currentPage();
        $totalPage = $result->total();
        if($result->isEmpty()){
            return [
                'data'=>[],
                'current_page'=>$currentPage
            ];
        }
        $result = $result->hidden(['snap_items','snap_address','prepay_id'])->toArray();
        return [
            'data'=>$result,
            'current_page'=>$currentPage,
            'total_page'=>$totalPage
        ];
    }
    /**
     * 根据订单id获取订单信息
     * @param int $size
     * @param int $page
     */
    public function getDetailById($id){
        $uid = Token::getUid();
        $result = OrderModel::getDetailById($id);
        if(!$result){
            throw new OrderException([
                'msg'=>'查询的订单不存在'
            ]);
        }
        $result = $result->hidden(['prepay_id'])->toArray();
        return $result;
    }
}