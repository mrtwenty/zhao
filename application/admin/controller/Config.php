<?php
namespace app\admin\controller;

use app\admin\controller\Base;
use think\Db;

class Config extends Base
{
    /**
     * 系统配置
     */
    public function index()
    {

        $request = request();

        if ($request->isPost()) {

            //1、接收
            $post                 = $request->post();
            $post['web_is_open']  = input('post.web_is_open/d', 0);
            $post['auth_is_open'] = input('post.auth_is_open/d', 0);

            $data = ['status' => 0];

            foreach ($post as $key => $val) {
                $res = Db::name('Config')->where('c_key', $key)->limit(1)->update(['c_value' => $val]);
                if ($key == 'admin_name' && $res) {
                    $data['status'] = 1;
                    $data['url']    = '/' . $val . url('/index/index');
                }
            }

            $this->success('成功!', null, $data);
        }

        $config = Db::name('Config')->where('c_type', 'base')->column('c_value', 'c_key');

        $this->assign('config', $config);
        return $this->fetch();
    }

    /**
     * 文件存储
     */
    public function uploads()
    {
        $request = request();

        if ($request->isPost()) {

            //接收
            $upload = input('post.upload');
            if (!isset($upload['is_open'])) {
                $upload['is_open'] = 0;
            }

            $oss   = input('post.oss');
            $qiniu = input('post.qiniu');

            //验证

            //入库
            foreach ($upload as $key => $value) {
                Db::name('Config')->where('c_key', 'upload_' . $key)->limit(1)->update(['c_value' => $value]);
            }

            $val = [
                'oss'   => $oss,
                'qiniu' => $qiniu,
            ];
            $res = Db::name('Config')->where('c_key', 'upload_params')->limit(1)->update(['c_value' => serialize($val)]);

            $this->success('成功');
        }

        $config = Db::name('Config')->where('c_type', 'upload')->column('c_value', 'c_key');
        $params = json_decode($config['upload_params'], true);
        // $params = [
        //     'oss'   => [
        //         'is_https'  => 'http',
        //         'bucket'    => '',
        //         'endpoint'  => '',
        //         'accesskey' => '',
        //         'secretkey' => '',
        //     ],
        //     'qiniu' => [
        //         'region'    => '华东',
        //         'is_https'  => 'http',
        //         'bucket'    => '.com',
        //         'domain'    => '1',
        //         'accesskey' => '',
        //         'secretkey' => '',
        //     ],
        // ];

        $this->assign('qiniu', $params['qiniu']);
        $this->assign('oss', $params['oss']);
        $this->assign('config', $config);
        return $this->fetch();
    }

    public function weixin()
    {
        $request = request();

        if ($request->isPost()) {

            //1、接收
            $post = $request->post();

            //3、修改
            foreach ($post as $key => $val) {
                $res = Db::name('Config')->where('c_key', $key)->limit(1)->update(['c_value' => $val]);
            }

            $this->success('成功!', null);
        }

        $config = Db::name('Config')->where('c_type', 'weixin')->column('c_value', 'c_key');

        $this->assign('config', $config);
        return $this->fetch();
    }
}
