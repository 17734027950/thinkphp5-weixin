<?php
namespace app\api\controller\v1;

use app\api\controller\v1\BaseController;
use app\api\validate\IDMustBeArray;
use app\api\validate\IDMustBePostiveInt;
use app\api\model\Theme as ThemeModel;
use app\lib\exception\ThemeMissException;
use app\lib\exception\ProductMissException;

class Theme extends BaseController{
    /**
     * 获取首页主题列表
     * @param int $ids
     * @return array $themeList
     */
    public function getThemeList(){
        $ids = input('get.');
        (new IDMustBeArray())->gocheck();
        $list = ThemeModel::getThemeList($ids);
        if($list->isEmpty()){
            throw new ThemeException();
        }
        return $list;
    }
    /**
     * 获取主题下的商品
     * @param int $id
     * @return array $theme
     */
    public function getThemeWithProducts($id){
        (new IDMustBePostiveInt())->goCheck($id);
        $theme = ThemeModel::getThemeWithProducts($id);
        if($theme->isEmpty()){
            throw new ThemeException([
                'msg'=>'请求的主题产品不存在'
            ]);
        }
        return $theme;
    }
}