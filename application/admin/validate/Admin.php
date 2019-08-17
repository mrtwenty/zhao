<?php

namespace app\admin\validate;

use think\Validate;

class Admin extends Validate
{
    /**
     * 定义验证规则
     * 格式：'字段名'    =>    ['规则1','规则2'...]
     *
     * @var array
     */
    protected $rule = [
        'username' => 'require|unique:admin|token',
        'password' => 'require|length:6,20',
        'is_used'  => 'require|in:0,1',
        'id'       => 'require|deleteId',
        'verify'   => 'callbackVerify',
    ];

    /**
     * 定义错误信息
     * 格式：'字段名.规则名'    =>    '错误信息'
     *
     * @var array
     */
    protected $message = [
        'username.require' => '登录名不能为空!',
        'username.unique'  => '登录名称已存在',
        'password.require' => '密码不能为空!',
        'password.length'  => '密码长度6-20位',
        'is_used.in'       => '请设置登录状态',
        'id.require'       => '参数丢失',
    ];

    //定义验证场景
    protected $scene = [
        'add'    => ['username', 'password', 'is_used'],
        'edit'   => ['username', 'password', 'is_used'],
        'used'   => ['id', 'is_used'],
        'delete' => ['id'],
        'login'  => ['username', 'password', 'verify'],
    ];

    public function sceneLogin()
    {
        return $this->only(['username', 'password', 'verify'])
            ->remove('password', 'length')
            ->remove('username', 'unique');
    }

    public function callbackVerify($value, $rule, $data, $field)
    {
        if (!captcha_check($value)) {
            return '验证码错误!';
        }

        return true;
    }

    // edit 验证场景定义
    public function sceneEdit()
    {
        return $this->only(['username', 'password', 'is_used'])
            ->remove('password', 'require')
            ->remove('username', 'unique');
    }

    public function deleteId($value, $rule, $data, $field)
    {

        $msg = '超级管理员admin不能删除!';

        if (is_numeric($value) && $value == 1) {
            return $msg;
        }

        if (is_array($value) && in_array(1, $value)) {
            return $msg;
        }
        return true;
    }

    public function sceneUsed()
    {
        return $this->only(['id', 'is_used'])
            ->remove('id', 'deleteId')
            ->append('id', 'require|callbackId');
    }

    protected function callbackId($value, $rule, $data, $field)
    {
        if ($value === 1) {
            return '超级管理员admin不能禁用!';
        }
        return true;
    }
}
