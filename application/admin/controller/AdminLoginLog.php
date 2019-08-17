<?php
namespace app\admin\controller;

use app\admin\controller\Base;
use app\admin\model\Admin;
use think\Db;

class AdminLoginLog extends Base
{
    /**
     * 登录日志
     * @return \think\Response
     */
    public function index()
    {
        $login_log = Db::name('AdminLoginLog');

        $url_param = input('get.');

        if (!empty($url_param['username']) && trim($url_param['username'])) {
            $admin_id = Db::name('admin')->where('username', 'LIKE', '%' . $url_param['username'] . '%')->column('id');
            $login_log->whereIn('admin_id', $admin_id);
        }

        if (!empty($url_param['time']) && trim($url_param['time'])) {
            $start = strtotime($url_param['time'] . ' 00:00:00');
            $end   = $start + 24 * 3600;
            $login_log->where('created_at', '>=', $start)->where('created_at', '<=', $end);
        }

        if (!empty($url_param['ip']) && $ip = trim($url_param['ip'])) {
            $ip = ip2long($ip);
            $login_log->where('ip', $ip);
        }

        $data = $login_log->order('id', 'desc')->paginate(17)->each(function ($item, $key) {
            $admin_model      = new Admin();
            $item['username'] = $admin_model->getUsername($item['admin_id']);
            return $item;
        });

        //获取分页显示
        $page = $data->render();
        $list = $data->items();

        $this->assign('get', $url_param);
        $this->assign('list', $list);
        $this->assign('page', $page);

        return $this->fetch();
    }
}
