<?php
namespace app\admin\behavior;

use app\admin\model\AdminActionLog;
use think\Request;

class Log
{
    public function run(Request $request, $params)
    {
        if (!session('?admin_id')) {
            return true;
        }

        $no_log = ['Auth', 'AdminActionLog']; //不需要记录日志的控制器，填在这里。

        if (in_array($request->controller(), $no_log)) {
            return true;
        }

        //记录操作日志
        $action_log = new AdminActionLog();

        $action_log->method     = $request->method(); //请求类型
        $action_log->params     = serialize(['get' => $request->get(), 'post' => $request->post()]);
        $action_log->url        = $request->pathinfo();
        $action_log->ip         = $request->ip(true);
        $action_log->admin_id   = session('admin_id');
        $action_log->created_at = time();

        $action_log->save();

    }
}
