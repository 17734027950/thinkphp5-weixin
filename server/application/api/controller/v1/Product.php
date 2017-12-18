<?php
namespace app\api\controller\v1;

use app\api\controller\v1\BaseController;
use app\api\model\Product as ProductModel;
use app\api\validate\Count;
use app\lib\exception\ProductException;

class Product extends BaseController{
    /**
     * @param int $count
     * @return array $products
     */
    public function getResent($count=15){
        (new Count())->goCheck();
        $products = ProductModel::getResent($count);
        if($products->isEmpty()){
            throw new ProductException();
        }
        $products = $products->hidden(['summary']);
        return $products;
    }
    /**
     * 获取分类商品
     * @param int $id
     */
    public function getByCategory($id){
        $products = ProductModel::getByCategory($id);
        if($products->isEmpty()){
            throw new ProductException();
        }
        $products = $products->hidden(['summary']);
        return $products;
    }
    /**
     * 获取商品详情
     * @param int $id
     */
    public function getDetails($id){
        $product = ProductModel::getDetails($id);
        return $product;
    }
}