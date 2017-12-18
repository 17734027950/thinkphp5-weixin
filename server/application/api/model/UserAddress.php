<?php
namespace app\api\model;
use app\api\model\BaseModel;

class UserAddress extends BaseModel{
    //隐藏字段
    protected $hidden = ['delete_time', 'update_time', 'user_id'];
    /**
     * 新增或更新地址
     */
    public static function saveAddress($data, $uid){
        $address = self::get(['user_id'=>$uid]);
        if($address){
            //更新
            $address->save($data, ['user_id'=>$uid]);
        }else{
            //新建
            $address = self::create([
                'name'=>$data['name'],
                'mobile'=>$data['mobile'],
                'province'=>$data['province'],
                'city'=>$data['city'],
                'country'=>$data['country'],
                'detail'=>$data['detail'],
                'user_id'=>$uid
            ]);
        }
    }
}