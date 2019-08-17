<?php
namespace app\admin\model;

use think\Model;

class AdminLoginLog extends Model
{
    protected $insert   = ['created_at','ip','admin_id'];


    protected function setCreatedAtAttr()
    {
        return time();
    }
    
    protected function setIpAttr()
    {
        return request()->ip(1);
    }

    protected function setAdminIdAttr()
    {
        return session('admin_id');
    }
}