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
    //关联图片表
    public function imgs(){
        return $this->hasMany('ProductImage', 'product_id', 'id');
    }
    //关联商品属性表
    public function properties(){
        return $this->hasMany('ProductProperty', 'product_id', 'id');
    }
    /**
     * 获取最近商品
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
    /**
     * 获取商品详情
     * @param int $id
     */
    public static function getDetails($id){
        $product = self::with([
            'imgs'=>function($query) {
                $query->with(['imgUrl'])->order('order','asc');
            }
        ])->with(['properties'])->find($id);;
        return $product;
    }
}