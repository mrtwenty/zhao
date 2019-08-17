<?php
namespace app\admin\controller;

use app\admin\controller\Base;
use app\admin\model\Admin;
use think\Db;

class AdminActionLog extends Base
{
    /**
     * 操作日志
     */
    public function index()
    {
        $url_param = input('get.');

        $admin_action_log = Db::name('AdminActionLog');

        if (!empty($url_param['username']) && trim($url_param['username'])) {
            $id = Db::name('admin')->where('username', 'LIKE', '%' . $url_param['username'] . '%')->column('id');
            $admin_action_log->whereIn('id', $id);
        }

        if (!empty($url_param['time']) && trim($url_param['time'])) {
            $start = strtotime($url_param['time'] . ' 00:00:00');
            $end   = $start + 24 * 3600;
            $admin_action_log->where('created_at', '>=', $start)->where('created_at', '<=', $end);
        }

        if (!empty($url_param['method']) && trim($url_param['method'])) {
            $admin_action_log->where('method', $url_param['method']);
        }

        if (!empty($url_param['ip']) && trim($url_param['ip'])) {
            $ip = ip2long($url_param['ip']);
            $admin_action_log->where('ip', $ip);
        }

        $data = $admin_action_log->order('id', 'desc')->paginate(13, false, ['query' => $url_param])->each(function ($item, $key) {
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

    /**
     * 查看详细数据
     */
    public function look($id = null)
    {
        if (empty($id)) {
            $this->error('参数错误');
        }

        $info = Db::name('AdminActionLog')->where('id', $id)->value('params');

        $info = unserialize($info);

        $this->success('成功!', null, $info);
    }
}
