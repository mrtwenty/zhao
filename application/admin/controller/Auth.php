<?php

namespace app\admin\controller;

use app\admin\model\Admin as AdminModel;
use app\admin\model\AdminLoginLog;
use app\admin\service\AdminService;
use think\captcha\Captcha;
use think\Controller;

/**
 * 后台认证控制器
 */
class Auth extends Controller
{
    /**
     * 登录
     */
    public function login()
    {
        $request = request();

        if ($request->isPost()) {

            //1、接收
            $data = [];
            $data = $request->post();

            //2、验证数据
            $msg = $this->validate($data, 'admin.login');
            if (true !== $msg) {
                $this->error($msg, url('auth/login'));
            }

            //3、数据库密码验证
            $admin_model = new AdminModel();
            $condition   = ['username' => $data['username'], 'is_used' => 0];
            $info        = $admin_model->field('id,username,password')->where($condition)->find();

            if (empty($info)) {
                $this->error('账号或密码错误!', url('auth/login'));
            }

            if (false === password_verify($data['password'], $info['password'])) {
                $this->error('账号或密码错误!', url('auth/login'));
            }

            session('admin_id', $info['id']);
            session('admin_username', $info['username']);

            //获取用户的权限
            $admin_service = new AdminService();
            session('permission_list', $admin_service->getPermissionList());

            //记录登录日志:
            $log = new AdminLoginLog();
            $log->save();

            //4、登录信息 session记录
            $this->success('登录成功!', url('index/index'));
        }

        return $this->fetch();
    }

    /**
     * 退出
     * @return [type] [description]
     */
    public function logout()
    {
        session(null);

        $url = config('admin_name') . '/auth/login';
        return redirect($url);
    }

    public function verify()
    {
        $config = [
            'length'   => 4,
            'fontSize' => 15,
            'useCurve' => false, //是否混淆曲线
            'useNoise' => false, //是否添加杂点
        ];

        $captcha = new Captcha($config);
        return $captcha->entry();
    }

    public function hacker()
    {
        exception('模块不存在!');
    }
}
