<?php
namespace app\api\service;
class Token
{
    /**
     * @return string
     * 形成随机token
     */
    public static function generateToken() {
        //32个随机组成的随机字符串
        $randChars = getRandChars(32);
        $timestamp = $_SERVER['REQUEST_TIME'];
        $salt = config('secure.token_salt');
        return md5($randChars.$timestamp.$salt);
    }
}