<?php
namespace app\api\controller\v1;

use think\Controller;
use app\api\validate\IDMustBeArray;
use app\api\validate\IDMustBePostiveInt;

class Theme extends Controller{
    /**
     * 获取主题列表
     * @param int $ids
     * @return array $themeList
     */
    public function getThemeList(){
        $ids = input('get.');
        (new IDMustBeArray())->gocheck($ids);
    }
    /**
     * 获取选定主题
     * @param int $id
     * @return array $theme
     */
    public function getTheme(){
        $id = input('');
        (new IDMustBePostiveInt())->goCheck($id);
    }
}