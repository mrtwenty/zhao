<?php
namespace app\admin\controller;

use app\admin\model\Rule;
use think\Controller;
use think\facade\Session;

class Base extends Controller
{

    protected function initialize()
    {
        //这里做判断，除了 Admin 继承 Controller，其他的所有控制器必须继承 Base
        if (!session('?admin_id')) {
            return $this->error('请登陆之后在操作！', url('auth/login'));
        }

        //是否开启权限认证
        if (!config('auth_is_open')) {
            return;
        }

        $request = request();
        $con     = $request->controller();
        $act     = $request->action();

        if ($con === 'Index') {
            return;
        }

        $url = get_rule_url($con, $act);

        $rule = new Rule();
        $id   = $rule->getRuleIdByUrl($url);

        if (empty($id)) {
            return $this->error('请添加该权限规则!', url('index/welcome'));
        }

        $permission_list = session('permission_list');
        if (!in_array($id, $permission_list)) {
            return $this->error('您暂无权限执行此操作!');
        }
    }
}
