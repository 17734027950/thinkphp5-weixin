<?php
namespace app\api\service;

use app\api\model\Product;
use app\api\model\Order as OrderModel;
use app\api\model\OrderProduct;
use app\lib\exception\OrderException;
use app\api\model\UserAddress;
use think\Db;

class Order {
    //用户传过来的产品
    protected $oProducts;
    //数据库中的产品
    protected $Products;
    protected $uid;
    /**
     * 下单处理
     * @param int $uid
     * @param array $Products
     * @return array $status
     */
    public function place($uid, $oProducts){
        $this->oProducts = $oProducts;
        $this->uid = $uid;
        //根据用户订单获取数据库真实订单
        $this->Products = $this->getProductsByOrder($oProducts);
        //获取订单状态
        $status = $this->getOrderStatus();
        if(!$status['pass']){
            $status['order_id'] = -1;
            return $status;
        }
        //生成订单快照
        $orderSnap = $this->snapOrder($status);
        //创建订单
        $order = $this->createOrder($orderSnap);
        return $status;
    }
    /**
     * 根据用户订单获取产品
     * @param array $Products
     * @return array $Products
     */
    private function getProductsByOrder($Products){
        $proIds = [];
        foreach($Products as $v){
            array_push($proIds, $v['product_id']);
        }
        $result = Product::all($proIds)->visible(['id','price','stock','name','main_img_url'])
        ->toArray();
        return $result;
    }
    /**
     * @return array
     * 获取订单状态
     */
    private function getOrderStatus() {
        $status = [
            'pass'=>true,
            'orderPrice'=>0,
            'totalCount'=>0,
            'pStatusArray'=>[]
        ];
        foreach($this->oProducts as $oProduct) {
            $pStatus = $this->getProductStatus(
                $oProduct['product_id'],$oProduct['count'],$this->Products
            );
            if(!$pStatus['haveStock']) {
                $status['pass'] = false;
            }
            $status['totalCount']+=$pStatus['counts'];
            $status['orderPrice']+=$pStatus['totalPrice'];
            array_push($status['pStatusArray'],$pStatus);
        }
        return $status;
    }

    /**
     * @param $oPID
     * @param $oCount
     * @param $Products
     * @return array
     * @throws OrderException
     * 获取某个商品的订单状态
     */
    private function getProductStatus($oPID,$oCount,$Products) {
        $pIndex = -1;
        $pStatus = [
            'id'=>null,
            'haveStock'=>false,
            'counts'=>0,
            'name'=>'',
            'price'=>0,
            'main_img_url',
            'totalPrice'=>0
        ];
        for($i = 0;$i<count($Products);$i++) {
            if($oPID == $Products[$i]['id']) {
                $pIndex = $i;
            }
        }
        if($pIndex == -1) {
            throw new OrderException([
                'msg'=>'ID'.'为'.$oPID.'的商品不存在,创建订单失败'
            ]);
        }else {
            $product = $Products[$pIndex];
            $pStatus['id'] = $product['id'];
            $pStatus['name'] = $product['name'];
            $pStatus['counts'] = $oCount;
            $pStatus['main_img_url'] = $product['main_img_url'];
            $pStatus['price'] = $product['price'];
            $pStatus['totalPrice'] = $oCount*$product['price'];
            if($product['stock']-$oCount>=0) {
                $pStatus['haveStock'] = true;
            }else {
                $pStatus['haveStock'] = false;
            }
        }
        return $pStatus;
    }
    /**
     * @param $snap
     * @return array
     * @throws Exception
     * 创建订单
     */
    private function createOrder($snap) {
        Db::startTrans();
        try {
            $orderNO = $this->makeOrderNo();
            $order = new OrderModel();
            $order->user_id = $this->uid;
            $order->order_no = $orderNO;
            $order->total_price = $snap['totalPrice'];
            $order->total_count = $snap['totalCount'];
            $order->snap_img = $snap['snapImage'];
            $order->snap_address = $snap['snapAddress'];
            $order->snap_name = $snap['snapName'];
            $order->snap_items = json_encode($snap['pStatus']);
            $order->save();
            $orderId = $order->id;
            $create_time = $order->create_time;
            //写入order_product表
            $orderProduct = new OrderProduct();
            foreach ($this->oProducts as &$oProduct) {
                $oProduct['order_id'] = $orderId;
            }
            $orderProduct->saveAll($this->oProducts);
            Db::commit();
        }catch (Exception $ex) {
            Db::rollback();
            throw $ex;
        }
        return [
            'order_no'=>$orderNO,
            'order_id'=>$orderId,
            'create_time'=>$create_time
        ];

    }

    /**
     * @return string
     * 随机产生订单编号
     */
    private function makeOrderNo() {
        $yCode = array('A','B','C','D','E','F','G','H','I','J');
        $orderSn = $yCode[intval(date('Y'))-2017].strtoupper(dechex(date('m'))).date('d').substr(time(),-5).substr(microtime(),2,5).sprintf('%02d',rand(0,99));
        return $orderSn;
    }

    /**
     * @param $status
     * @return array
     * 订单快照，存储当时订单的详细信息
     */
    public function snapOrder($status) {
        $snap = [
            'totalPrice'=>0,
            'totalCount'=>0,
            'pStatus'=>[],
            'snapAddress'=>null,
            'snapName'=>'',
            'snapImage'=>''
        ];
        $snap['totalPrice'] = $status['orderPrice'];
        $snap['totalCount'] = $status['totalCount'];
        $snap['pStatus'] = $status['pStatusArray'];
        $snap['snapAddress'] = json_encode($this->getUserAddress());
        $snap['snapName'] =$this->Products[0]['name'];
        $snap['snapImage'] = $this->Products[0]['main_img_url'];
        if(count($this->oProducts)>1) {
            $snap['snapName'] .='等';
        }
        return $snap;
    }
    /**
     * 获取用户地址
     */
    private function getUserAddress(){
        $address = UserAddress::get(['user_id'=>$this->uid]);
        if(!$address){
            throw new OrderException([
                'msg'=>'用户地址不存在，创建订单失败'
            ]);
        }
        return $address;
    }
}