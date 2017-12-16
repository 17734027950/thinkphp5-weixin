<?php
namespace app\api\model;

use app\api\model\BaseModel;

class Image extends BaseModel{
    //隐藏字段
    protected $hidden = ['delete_time','update_time','from','id'];
    /**
     * 获取图片完整url路径
     * @param string $value
     * @param array $data
     * @return string url
     */
    protected function getUrlAttr($value, $data){
        return $this->getImgUrl($value, $data); 
    }
}