<?php

namespace app\admin\validate;

use think\Validate;

class Index extends Validate
{
    /**
     * 定义验证规则
     * 格式：'字段名'    =>    ['规则1','规则2'...]
     *
     * @var array
     */
    protected $rule = [
        'old_password'     => 'require|oldPassword',
        'password'         => 'require',
        'confirm_password' => 'require|confirmPassword',
    ];

    /**
     * 定义错误信息
     * 格式：'字段名.规则名'    =>    '错误信息'
     *
     * @var array
     */
    protected $message = [
        'old_password.require'     => '旧密码不能为空!',
        'password.require'         => '密码不能为空!',
        'confirm_password.require' => '确认密码不能为空!',
    ];

    protected function confirmPassword($value, $rule, $data, $field)
    {
        if ($value !== $data['password']) {
            return '密码与确认密码不相同!';
        }

        return true;
    }

    protected function oldPassword($value, $rule, $data, $field)
    {
        $password = db('Admin')->field('password')->where('id', $data['id'])->value('password');

        if (!password_verify($value, $password)) {
            return '旧密码错误!';
        }

        return true;
    }
}
