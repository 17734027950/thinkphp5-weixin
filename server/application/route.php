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

Route::get('api/:version/banner/:id$', 'api/:version.Banner/getBanner');

Route::get('api/:version/theme$', 'api/:version.Theme/getThemeList');
Route::get('api/:version/theme/:id$', 'api/:version.Theme/getThemeWithProducts');

Route::get('api/:version/product/resent$', 'api/:version.Product/getResent');
Route::get('api/:version/product/by_category/:id$', 'api/:version.Product/getByCategory');

Route::get('api/:version/cate/all$', 'api/:version.Category/getAllCategory');

Route::post('api/:version/token/user/$', 'api/:version.User/getToken');
