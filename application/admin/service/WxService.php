<?php
namespace app\admin\service;

use EasyWeChat\Factory;

/**
 * WxService 用来处理微信公众号的服务的
 */
class WxService
{
    private $weixin;

    public function __construct()
    {
        $config = [
            'app_id' => config('weixin_appid'),
            'secret' => config('weixin_appsecret'),
            'token'  => config('weixin_token'),
            'oauth'  => [
                'scopes'   => ['snsapi_userinfo'],
                'callback' => '/index/auth/callback',
            ],
        ];

        $this->weixin = Factory::officialAccount($config);
    }

    /**
     * 获取跳转的微信授权认证的url
     * @return [type] [description]
     */
    public function getOauthUrl()
    {
        $res = $this->weixin->oauth->redirect();
        return $res->headers->get('Location');
    }

    /**
     *  获取 OAuth 授权结果用户信息
     * @return [type] [description]
     */
    public function getOauth()
    {
        $oauth = $this->weixin->oauth;

        return $oauth->user()->toArray();
    }

    public function getMenu()
    {
        return $this->weixin->menu;
    }
}
