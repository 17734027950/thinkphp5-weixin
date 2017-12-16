<?php
namespace app\api\model;
use app\api\model\BaseModel;

class Product extends BaseModel{
    //隐藏字段
    protected $hidden = ['delete_time','create_time','update_time','pivot','img_id','from','category_id'];
    
}