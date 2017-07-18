<?php

namespace frontend\widgets;

use yii\authclient\OAuth2;
use yii\web\HttpException;
use Yii;

class QQClient extends OAuth2
{
    public $authUrl = 'https://graph.qq.com/oauth2.0/authorize';
    
    public $tokenUrl = 'https://graph.qq.com/oauth2.0/token';
    
    public $apiBaseUrl = 'https://graph.qq.com';
    
    protected function initUserAttributes()
    {
        $user = $this->api('user/get_user_info', 'GET', ['oauth_consumer_key' => $this->user->client_id, 'openid' => $this->user->openid]);
        
        return [
            'client' => 'qq',
            'openid' => $this->user->openid,
            'nickname' => $user['nickname'],
            'gender' => $user['gender'],
            'location' => $user['province'] . $user['city'],
        ];
    }
    
    protected function getUser()
    {
        $str = file_get_contents('https://graph.qq.com/oauth2.0/me?access_token=' . $this->accessToken->token);
        
        if (strpos($str, "callback") !== false) {
            $lops = strpos($str, "(");
            $rops = strrpos($str, ")");
            $str = substr($str, $lops + 1, $rops - $lops -1);
        }
        
        return json_decode($str);
    }
    
    protected function defaultName()
    {
        return 'QQ';
    }
    
    protected function defaultTitle()
    {
        return 'QQ登录';
    }
}

