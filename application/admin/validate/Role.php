<?php

namespace app\admin\validate;

use think\Validate;

class Role extends Validate
{
    /**
     * 定义验证规则
     * 格式：'字段名'    =>    ['规则1','规则2'...]
     *
     * @var array
     */
    protected $rule = [
        'role_name' => 'require|max:30',
        'role_desc' => 'require|max:255',
    ];

    /**
     * 定义错误信息
     * 格式：'字段名.规则名'    =>    '错误信息'
     *
     * @var array
     */
    protected $message = [
        'role_name.require' => '角色不能为空',
        'role_name.max'     => '角色名不能超过30个字符',
        'role_desc.require' => '角色描述不能为空',
        'role_desc.max'     => '描述不能超过255个字符',
    ];

}
