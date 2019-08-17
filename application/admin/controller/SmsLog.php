<?php
namespace app\admin\controller;

use app\admin\controller\Base;
use Think\Db;

class SmsLog extends Base
{
    public function index()
    {
        $url_param = input('get.');

        $sms_log = Db::name('smsLog');

        if (!empty($url_param['time']) && trim($url_param['time'])) {
            $start = strtotime($url_param['time'] . ' 00:00:00');
            $end   = $start + 24 * 3600;
            $sms_log->where('created_at', '>=', $start)->where('created_at', '<=', $end);
        }

        if (!empty($url_param['ip']) && trim($url_param['ip'])) {
            $ip = ip2long($url_param['ip']);
            $sms_log->where('ip', $ip);
        }

        if (!empty($url_param['mobile']) && trim($url_param['mobile'])) {
            $sms_log->where('mobile', $url_param['mobile']);
        }

        $data = $sms_log->order('id', 'desc')->paginate(13, false, ['query' => $url_param]);

        //获取分页显示
        $page = $data->render();
        $list = $data->items();

        $this->assign('get', $url_param);
        $this->assign('list', $list);
        $this->assign('page', $page);

        return $this->fetch();
    }

    public function look($id = null)
    {
        if (empty($id)) {
            $this->error('参数错误');
        }

        $info = Db::name('SmsLog')->where('id', $id)->value('res');

        $info = unserialize($info);

        $this->success('成功!', null, $info);
    }
}
