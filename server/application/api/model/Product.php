<?php
namespace app\api\model;
use app\api\model\BaseModel;

class Product extends BaseModel{
    //隐藏字段
    protected $hidden = ['delete_time','create_time','update_time','pivot','img_id','from','category_id'];
    //图片加完整前缀
    public function getMainImgUrlAttr($value, $data){
        return $this->getImgUrl($value, $data);
    }
    //关联Category表
    public function cate(){
        return $this->BelongsTo('Category', 'category_id', 'id');
    }
    /**
     * @param int $count
     * @return array $products
     */
    public static function getResent($count){
        $products = self::limit($count)->order('create_time desc')->select();
        return $products;
    }
    /**
     * 获取分类商品
     * @param int $id
     */
    public static function getByCategory($id){
        $products = self::all(['category_id'=>$id]);
        return $products;
    }
}