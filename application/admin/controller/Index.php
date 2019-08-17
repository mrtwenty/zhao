<?php
namespace app\admin\controller;

use app\admin\controller\Base;
use app\admin\model\Admin as AdminModel;
use app\admin\model\Rule as RuleModel;
use app\admin\service\AdminService;
use app\admin\validate\Index as IndexValidate;
use app\common\service\UploadService;
use think\App;
use think\Db;

//后台首页入口
class Index extends Base
{
    public function index()
    {
        config('app_trace', false); //关闭调试

        $rule_model = new RuleModel();
        $menu_tree  = $rule_model->getMenu();

        $this->assign('menu_tree', $menu_tree);
        return $this->fetch();
    }

    public function welcome()
    {

        $info = Db::query('SELECT version() as v');

        $this->assign('think_version', App::VERSION);
        $this->assign('mysql_version', $info[0]['v']);

        return $this->fetch();
    }

    /**
     * 修改个人资料
     */
    public function config()
    {
        $id      = session('admin_id');
        $request = request();

        if ($request->isPost()) {

            $data       = input('post.');
            $data['id'] = $id;

            //验证
            $indexValidate = new IndexValidate();
            if (!$indexValidate->check($data)) {
                $this->error($indexValidate->getError());
            }

            $info           = AdminModel::get($id);
            $info->password = $data['password'];
            $info->save();
            $this->success('成功!');
        }

        $info = Db::name('admin')->find($id);
        $this->assign('info', $info);
        return $this->fetch();
    }

    /**
     * 重新刷新权限
     */
    public function refresh()
    {
        $admin_service = new AdminService();
        session('permission_list', $admin_service->getPermissionList());

        $rule_model = new RuleModel();
        $menu_tree  = $rule_model->getMenu();

        $this->assign('menu_tree', $menu_tree);

        $str = $this->fetch('menu');

        $this->success('成功!', null, $str);
    }

    /**
     * 文件上传
     */
    public function uploads()
    {
        //判断是否开启了文件上传
        if (!config('upload_is_open')) {
            $this->error('暂时关闭文件上传!');
        }

        $file = request()->file('file');

        $ext  = config('upload_ext'); //文件类型
        $size = config('upload_size'); //文件大小

        $info = $file->validate(['size' => $size * 1024 * 1024, 'ext' => $ext])->check();

        if (!$info) {
            $this->error($file->getError());
        }

        //存储方式
        $type = config('upload_type');
        if (!in_array($type, ['local', 'qiniu', 'oss'])) {
            $this->error('不存在该存储方式');
        }

        $dir = input('get.path', '', 'trim');
        if (empty($dir)) {
            $this->error('没有上传目录参数');
        }

        $config = unserialize(config('upload_params'));

        $file_service = new UploadService($file, $config);

        $file_service->$type($dir);
    }
}
