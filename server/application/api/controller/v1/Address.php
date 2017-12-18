<?php
namespace app\api\controller\v1;
use app\api\controller\v1\BaseController;
use app\api\validate\AddressNew;
use app\api\service\Token;
use app\lib\exception\SuccessMessage;
use app\api\model\UserAddress as UserAddressModel;

class Address extends BaseController{
    /**
     * 新增或更新收货地址
     */
    public function createOrUpdateAddress(){
        $validate = new AddressNew();
        //验证参数是否完整
        $validate->goCheck();
        //获取用户uid
        $uid = Token::getUid();
        //非法参数过滤
        $data = input('post.');
        $validate->isParamLegal($data);
        //保存数据库
        UserAddressModel::saveAddress($data, $uid);

        return json(new SuccessMessage(), 201);
    }
}