<?php
namespace app\api\model;
use app\api\model\BaseModel;

class Order extends BaseModel{
    /**
     * 获取订单简要信息
     * @param int $size
     * @param int $page
     * @return array
     */
    public static function getSummary($size, $page){
        
        $result = self::order('create_time', 'desc')->paginate($size, false, [
            'page'=>$page
        ]);
        return $result;
    }
    /**
     * 根据用户获取订单信息
     * @param int $uid
     * @param int $size
     * @param int $page
     * @return array
     */
    public static function getOrderByUser($uid, $size, $page){
        $result = self::where('user_id', $uid)->order('create_time', 'desc')->paginate($size, false, [
            'page'=>$page
        ]);
        return $result;
    }
    /**
     * 根据订单id获取订单信息
     * @param int $order_id
     * @param int $size
     * @param int $page
     * @return array
     */
    public static function getDetailById($id){
        $result = self::get($id);
        return $result;
    }
}