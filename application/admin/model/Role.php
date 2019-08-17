<?php
namespace app\admin\model;

use think\Model;

class Role extends Model
{    
    protected $insert = ['created_at'];
    
    protected function setCreatedAtAttr()
    {
        return time();
    }
    
}