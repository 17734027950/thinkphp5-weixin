<?php
namespace app\api\model;
use app\api\model\BaseModel;

class ProductImage extends BaseModel{
    //隐藏字段
    protected $hidden = ['delete_time', 'update_time', 'product_id'];
    //关联Image表
    public function imgUrl(){
        return $this->belongsTo('Image', 'img_id', 'id');
    }
}