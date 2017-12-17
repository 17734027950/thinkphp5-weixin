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

Route::get('/:version/banner/:id$', 'api/:version.Banner/getBanner');

Route::get('/:version/theme$', 'api/:version.Theme/getThemeList');
Route::get('/:version/theme/:id$', 'api/:version.Theme/getThemeWithProducts');

Route::get('/:version/product/resent$', 'api/:version.Product/getResent');
Route::get('/:version/product/by_category/:id$', 'api/:version.Product/getByCategory');

Route::get('/:version/cate/all$', 'api/:version.Category/getAllCategory');
