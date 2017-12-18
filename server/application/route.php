<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

use think\Route;
//首页轮播图
Route::get('api/:version/banner/:id', 'api/:version.Banner/getBanner');
//主题分组
Route::group('api/:version/theme', function(){
    Route::get('/', 'api/:version.Theme/getThemeList');
    Route::get('/:id', 'api/:version.Theme/getThemeWithProducts'); 
});
//产品分组
Route::group('api/:version/product', function(){
    Route::get('/resent', 'api/:version.Product/getResent');
    Route::get('/by_category/:id', 'api/:version.Product/getByCategory', [], ['id'=>'\d+']);
    Route::get('/:id', 'api/:version.Product/getDetails', [], ['id'=>'\d+']);
});
//分类
Route::get('api/:version/cate/all', 'api/:version.Category/getAllCategory');
//token验证
Route::post('api/:version/token/user', 'api/:version.User/getToken');
//收货地址
Route::post('api/:version/address', 'api/:version.Address/createOrUpdateAddress');