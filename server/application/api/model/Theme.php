<?php
namespace app\api\model;

use app\api\model\BaseModel;

class Theme extends BaseModel{
    //隐藏字段
    protected $hidden = ['topic_img_id', 'head_img_id', 'delete_time', 'update_time'];
    /**
     * 关联Product表
     */
    public function products(){
        return $this->belongsToMany('Product', 'theme_product', 'product_id', 'theme_id');
    }
    public function topicImg(){
        return $this->belongsTo('Image', 'topic_img_id', 'id');
    }
    public function headImg(){
        return $this->belongsTo('Image', 'head_img_id', 'id');
    }
    /**
     * 获取首页专题
     * @param array $ids
     * @return array $themeList
     */
    public static function getThemeList($ids){
        $ids = explode(',', $ids['ids']);
        $themeList = self::all($ids);
        return $themeList;
    }
    /**
     * 获取专题产品
     * @param int $id
     * @return array $products
     */
    public static function getThemeWithProducts($id){
        $theme = self::with(['products','topicImg', 'headImg'])->find($id);
        return $theme;
    }
}