<?php

namespace app\admin\validate;

use think\Validate;

class Rule extends Validate
{
    /**
     * 定义验证规则
     * 格式：'字段名' =>  ['规则1','规则2'...]
     *
     * @var array
     */
    protected $rule = [
        'rule_url ' => 'require|max:255',
        'rule_desc' => 'require|max:255',
        'id'        => 'require',
    ];

    /**
     * 定义错误信息
     * 格式：'字段名.规则名' =>  '错误信息'
     *
     * @var array
     */
    protected $message = [
        'rule_url.require'  => '规则URL不能为空',
        'rule_url.max'      => '规则URL不能超过255个字符',
        'rule_desc.require' => '规则说明不能为空',
        'rule_desc.max'     => '规则说明不能超过255个字符',
    ];

    //定义验证场景
    protected $scene = [
        'edit'   => ['rule_url', 'rule_desc'],
        'delete' => ['id'],
    ];

}
