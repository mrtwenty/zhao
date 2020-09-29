<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件

/**
 * 输出select标签
 * @return [type] [description]
 */
function lay_select($name, $class, $data = [], $id = null, $is_val = 'val', $disabled = 0)
{
    $dis = $disabled == 1 ? 'disabled' : '';

    $str = '<select ' . $dis . ' name="' . $name . '" class="' . $class . '" lay-filter="' . $class . '"><option value="">请选择</option>';
    foreach ($data as $k => $v) {
        if ($is_val === 'val') {
            $temp = $id === $k ? 'selected' : '';
        } else {
            $temp = $id === $v ? 'selected' : '';
        }
        $str .= '<option ' . $temp . ' value="' . $k . '">' . $v . '</option>';
    }
    $str .= '</select>';
    return $str;
}

function lay_switch($name, $val = 0)
{
    $checked = '';
    if ($val == 0) {
        $checked = 'checked';
    }

    $str = '<input type="checkbox" lay-filter="' . $name . '_switch" ' . $checked . ' lay-skin="switch">';
    $str .= '<input type="hidden" name="' . $name . '" value="' . $val . '">';
    return $str;
}

function lay_switch_list($name, $val, $id)
{
    $request  = request();
    $module   = $request->module();
    $temp_str = under_line2upper($name);

    $url = url($temp_str, ['id' => $id]);

    $checked = '';
    if ($val == 0) {
        $checked = 'checked';
    }
    $str = '<input value="' . $url . '" type="checkbox" lay-filter="' . $name . '" ' . $checked . ' lay-skin="switch">';

    return $str;
}

/**
 * 将IP地址转换成可读的中文格式
 * @param  string $ip ipv4格式
 * @return string
 */
function ip2region($ip)
{
    $ip2region = new \Ip2Region();
    $result    = $ip2region->btreeSearch($ip);
    $str       = isset($result['region']) ? $result['region'] : '';
    return str_replace(['0', '|'], '', $str);
}

/**
 * 将整型数字转成可读的中文格式
 * @param  int $long
 * @return string
 */
function long2region($long)
{
    $ip = long2ip($long);
    return ip2region($ip);
}

function get_img($img)
{

    $upload_type = config('upload_type');

    if ($upload_type === 'local') {
        $request = request();
        return $request->domain() . '/uploads' . $img;
    }

    $res = unserialize(config('upload_params'));

    $oss = $res['oss'];

    if ($upload_type === 'oss') {

        $base_url = $oss['bucket'] . '.' . $oss['endpoint'];

        if ($oss['is_https'] === 'https') {
            $protocol = 'https://';
        } else if ($oss['is_https'] === 'http') {
            $protocol = 'http://';
        } else {
            $protocol = '//';
        }

        return $protocol . $base_url . '/uploads/' . $img;
    }

    if ($upload_type === 'qiniu') {
        return '';
    }

}
