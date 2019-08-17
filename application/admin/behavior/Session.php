<?php
namespace app\admin\behavior;

use think\facade\Session as SessionService;

class Session
{

    public function run()
    {
        SessionService::init([
            'prefix'     => 'admin',
            'type'       => '',
            'name'       => 'zhao',
            'auto_start' => true,
        ]);
    }
}
