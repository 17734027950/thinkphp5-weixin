<?php
namespace app\api\model;
use think\Model;

class BaseModel extends Model{
    /**
     * 获取图片完整url
     * @param string $url
     * @return string $img_url
     */
    protected function getImgUrl($url, $data){
        $img_url = $url;
        if($data['from']===1){
            $pre = request()->domain();
            $img_url = $pre.'/images'.$url;
        }
        return $img_url;
    }
}