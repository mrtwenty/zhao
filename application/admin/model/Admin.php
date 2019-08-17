<?php
namespace app\admin\model;

use think\Model;

class Admin extends Model
{

    protected $insert = ['created_at', 'created_ip', 'password'];
    protected $update = [];

    protected function setCreatedAtAttr()
    {
        return time();
    }

    protected function setCreatedIpAttr()
    {
        return request()->ip(1);
    }

    protected function setPasswordAttr($val)
    {
        return password_hash($val, PASSWORD_DEFAULT);
    }

    public function updatePassword($password)
    {
        $password = trim($password);
        if (!empty($password)) {
            $this->password = $password;
        }
    }

    /**
     * 通过$admin_id获取用户名
     * @param  [type] $id [description]
     * @return [type]           [description]
     */
    public static function getUsername($id)
    {
        static $temp = [];
        if (array_key_exists($id, $temp)) {
            return $temp[$id];
        } else {
            $username  = self::where(['id' => $id])->value('username');
            $temp[$id] = $username;
            return $username;
        }
    }
}
