<?php
namespace app\admin\model;

use think\Model;

/**
 * 使用说明:
 * use app\admin\Model\Config;
 * Config::getValue('takeout_refund_is_add_stock,delivery_area ');
 */

class Config extends Model
{

    public function getConfig($type = 'base')
    {
        return $this->where('c_type', $type)->column('c_value', 'c_key');
    }

    public function setConfig($data, $type)
    {
        foreach ($data as $k => $v) {
            $this->where('c_type', $type)->where('c_key', $k)->update(['c_value' => $v]);
        }
    }

    /**
     * [getKey description]
     * @param  [type] $key [description]
     * @return [type]      [description]
     */
    public static function getValue($key)
    {
        $arr = explode(',', $key);

        if (count($arr) == 1) {
            return self::where('c_key', $arr[0])->value('c_value');
        }

        return self::whereIn('c_key', $arr)->column('c_value', 'c_key');
    }
}
