<?php
namespace app\admin\controller;

use app\admin\controller\Base;
use EasyWeChat\Factory;
use think\Db;

/**
 * 微信场景二维码
 */
class Wxqrcode extends Base
{

    private $weixin;

    protected function initialize()
    {
        parent::initialize();

        $config = [
            'app_id' => config('weixin_appid'),
            'secret' => config('weixin_appsecret'),
            'token'  => config('weixin_token'),
        ];

        $this->weixin = Factory::officialAccount($config);
    }

    public function index()
    {
        $data = Db::name('WxQrcode')->order('id', 'desc')->paginate(14);
        //获取分页显示
        $page = $data->render();
        $list = $data->items();

        //二维码类型 0永久二维码 1临时二维码
        foreach ($list as &$item) {
            if ($item['scene_type']) {
                $item['is_expire']      = intval($item['created_at']) + intval($item['expire_seconds']) - time() > 0 ? true : false;
                $item['expire_seconds'] = date('Y-m-d H:i:s', $item['expire_seconds'] + $item['created_at']);
                $item['scene_type']     = '临时';
            } else {
                $item['is_expire']      = true;
                $item['expire_seconds'] = '不过期';
                $item['scene_type']     = '永久';
            }
            $item['img'] = $this->weixin->qrcode->url($item['ticket']);

            $temp = Db::name('WxQrcodeStat')->field('stat_type,count(*)')->where('qr_id', $item['id'])->group('stat_type')->column('count(*)', 'stat_type');
            if (!empty($temp)) {
                $item['scan']      = $temp[1] ?? 0;
                $item['subscribe'] = $temp[0] ?? 0;
            } else {
                $item['scan']      = 0;
                $item['subscribe'] = 0;
            }

        }

        $this->assign('list', $list);
        $this->assign('page', $page);
        return $this->fetch();
    }

    public function add()
    {

        $request = request();

        if ($request->isPost()) {

            //接收
            $post = $request->post();

            //验证场景
            $scene_name = trim($post['scene_name']);
            if (Db::name('WxQrcode')->where('scene_name', $scene_name)->find()) {
                $this->error('该场景已存在，请重新取名！');
            }

            if (!in_array($post['scene_type'], [0, 1])) {
                $this->error('参数错误!');
            }

            $scene_str = md5($scene_name);

            //判断result的返回值
            if ($post['scene_type'] == 1) {
                $result = $this->weixin->qrcode->temporary($scene_str, $post['expire_seconds']);
            } else {
                $result = $this->weixin->qrcode->forever($scene_str);
            }

            $post['scene_str']      = $scene_str;
            $post['scene_name']     = $scene_name;
            $post['expire_seconds'] = $result['expire_seconds'] ?? 0;
            $post['url']            = $result['url'];
            $post['ticket']         = $result['ticket'];
            $post['created_at']     = time();
            $post['qrcode_img']     = '';

            if (Db::name('WxQrcode')->insert($post)) {
                $this->success('成功!');
            }
        }

        return $this->fetch();
    }

    public function delete($id)
    {
        $id = intval($id);
        if (empty($id)) {
            $this->error('参数错误!');
        }

        if (!Db::name('WxQrcode')->where('id', $id)->where('scene_type', 1)->find()) {
            $this->error('永久二维码不支持删除!');
        }

        $res = true;
        Db::startTrans();
        try {
            Db::name('WxQrcode')->where('id', $id)->delete();
            Db::name('WxQrcodeStat')->where('qr_id', $id)->delete();
            Db::commit();
        } catch (\Exception $e) {
            Db::rollback();
            $res = false;
        }

        if ($res) {
            $this->success('成功!', url('Wxqrcode/index'));
        }

        $this->error('失败!');
    }
}
