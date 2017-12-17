<?php
namespace app\api\controller\v1;

use think\Controller;
use app\api\validate\IDMustBePostiveInt;
use app\api\model\Banner as BannerModel;
use app\lib\exception\BannerMissException;
use app\api\controller\v1\BaseController;

class Banner extends BaseController
{
    /**
     * 获取banner轮播图
     * @param  int  $id
     * @return array $banner
     */
    public function getBanner($id)
    {
        (new IDMustBePostiveInt())->goCheck();
        $banner = BannerModel::getBanner($id);
        if($banner->isEmpty()){
            throw new BannerMissException();
        }
        return $banner;
    }
}
