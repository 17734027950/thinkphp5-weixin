<?php
namespace app\api\controller\v1;
use app\api\controller\v1\BaseController;
use app\api\model\Category as CategoryModel;
use app\lib\exception\CategoryException;

class Category extends BaseController{
    public function getAllCategory(){
        $cate = CategoryModel::all([], 'img');
        if($cate->isEmpty()){
            throw new CategoryException();
        }
        return $cate;
    }
}