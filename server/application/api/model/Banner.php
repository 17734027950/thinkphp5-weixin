<?php
namespace app\api\model;
use app\api\model\BaseModel;

class Banner extends BaseModel{
    //隐藏字段
    protected $hidden = ['delete_time', 'update_time', 'id'];
    /**
     * 获取banner轮播图
     * @param int $id
     * @return array $banner
     */
    public static function getBanner($id){
        $result = self::with(['items', 'items.img'])->find($id);
        return $result;
    }
    /**
     * 关联BannerItem表
     */
    public function items(){
        return $this->hasMany('BannerItem', 'banner_id', 'id');
    }
}