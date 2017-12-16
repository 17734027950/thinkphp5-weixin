<?php
namespace app\api\model;

use app\api\model\BaseModel;

class BannerItem extends BaseModel{
    //隐藏字段
    protected $hidden = ['delete_time','update_time','id','img_id','banner_id'];
    /**
     * 关联Image表
     */
    public function img(){
        return $this->belongsTo('Image', 'img_id', 'id');
    }
}