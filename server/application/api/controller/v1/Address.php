<?php
namespace app\api\controller\v1;
use app\api\controller\v1\BaseController;
use app\api\validate\AddressNew;
use app\api\service\Token;
use app\lib\exception\SuccessMessage;
use app\api\model\UserAddress as UserAddressModel;

class Address extends BaseController{
    protected $beforeActionList = [
        'checkPrimaryScope'=>['only'=>'createOrUpdateAddress,getAddress']
    ];
    
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

    /**
     * 获取收货地址
     */
    public function getAddress(){
        //获取用户uid
        $uid = Token::getUid();
        $address = UserAddressModel::get(['user_id'=>$uid]);
        return $address;
    }

    /**
     * 获取快递的信息
     */
    public function getEmsData() {
        $type = 'zhongtong';
        $openId = '463675727356';
        $url = "https://www.kuaidi100.com/query?type=".$type."&postid=".$openId;
        $arr = json_decode(curl_get($url),true);
        echo '快递单号：'.$openId.'<br/>';
        foreach ($arr['data'] as $k=>$v) {
            if($k == 0) {
                echo "<span style='color: red'>".$v['time'].'&emsp;'.$v['context'].'&emsp;'.$v['location']."</span><br/>";
            }else {
               echo "<span>".$v['time'].'&emsp;'.$v['context'].'&emsp;'.$v['location']."</span><br/>";
            }
        }
    }

    /**
     *短信验证码的功能
     */
    public function sendCode() {
        $mobile = '13053112897';
        $tpl_id = 53036;
        $key = '98cfbf52a2ef191424ff071f4ae1615b';
        $url = "http://v.juhe.cn/sms/send?mobile=".$mobile."&tpl_id=".$tpl_id."&key=".$key."&tpl_value=";
        $code = rand(1000,9999);
        $str = '#code#='.$code;
        $str = urlencode($str);
        $url = $url.$str;
        $arr = json_decode(curl_get($url),true);
        if($arr['error_code'] == 0) {
            echo '发送成功';
        }else {
            echo '发送失败';
        }
    }
}