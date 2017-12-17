<?php
namespace app\api\model;

use app\api\model\BaseModel;

class Category extends BaseModel{
    //隐藏字段
    protected $hidden = ['update_time', 'create_time', 'delete_time'];
    //关联Image表
    public function img(){
        return $this->BelongsTo('Image', 'topic_img_id', 'id');
    }
}