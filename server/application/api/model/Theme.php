<?php
namespace app\api\model;

use app\api\model\BaseModel;

class Theme extends BaseModel{
    //隐藏字段
    protected $hidden = ['topic_img_id', 'head_img_id', 'delete_time', 'update_time'];
    /**
     * 关联Product表
     */
    public function product(){
        return $this->belongsToMany('Product', 'theme_product', 'product_id', 'theme_id');
    }
}