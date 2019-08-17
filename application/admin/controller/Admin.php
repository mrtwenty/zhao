<?php
namespace app\admin\controller;

use app\admin\controller\Base;
use app\admin\service\AdminService;
use think\Db;

class Admin extends Base
{
    public function index()
    {
        $data = Db::name('admin')->order('id', 'asc')->paginate(13)->each(function ($item, $key) {
            $admin_service     = new AdminService();
            $item['role_name'] = $admin_service->getAdminRoleNameList($item['id']);
            return $item;
        });

        //获取分页显示
        $page = $data->render();
        $list = $data->items();

        $this->assign('list', $list);
        $this->assign('page', $page);
        return $this->fetch();
    }

    public function add()
    {
        $request = request();

        if ($request->isPost()) {

            //接收
            $post            = $request->post();
            $post['is_used'] = input('post.is_used/d', 1);

            //验证
            $msg = $this->validate($post, 'admin.add');
            if (true !== $msg) {
                $this->error($msg);
            }

            //入库
            $admin_service = new AdminService();
            $admin_service->insertAdmin($post);
        }

        $role_list = Db::name('Role')->field('role_name,id')->select();
        $this->assign('role_list', $role_list);
        return $this->fetch();
    }

    public function edit($id)
    {
        $id      = (int) $id;
        $request = request();

        if ($request->isPost()) {

            //接收
            $post            = $request->post();
            $post['is_used'] = input('is_used', 1);

            //验证
            $msg = $this->validate($post, 'admin.edit');
            if (true !== $msg) {
                $this->error($msg);
            }

            //入库
            $admin_service = new AdminService();
            $admin_service->updateAdmin($post, $id);
        }

        $info       = Db::name('admin')->find($id);
        $role_list  = Db::name('role')->field('role_name,id')->select();
        $admin_role = Db::name('admin_role')->field('role_id')->where('admin_id', $id)->column('role_id');

        $this->assign('info', $info); //管理员的基本信息
        $this->assign('admin_role', $admin_role); //管理员所拥有的角色
        $this->assign('role_list', $role_list); //所有的角色
        return $this->fetch();
    }

    public function delete($id = null)
    {
        $id = (int) $id;

        if (empty($id)) {
            $id = (array) input('post.ids');
        }

        //验证
        $msg = $this->validate(['id' => $id], 'admin.delete');
        if (true !== $msg) {
            $this->error($msg);
        }

        //入库
        $admin_service = new AdminService();
        $admin_service->deleteAdmin($id);
    }

    public function usedStatus($id)
    {
        $is_used = input('post.stat/d', 0);
        $id      = (int) $id;

        $data = ['id' => $id, 'is_used' => $is_used];

        //验证
        $msg = $this->validate($data, 'admin.used');
        if (true !== $msg) {
            $this->error($msg);
        }

        //执行
        if (Db::name('Admin')->where('id', $id)->update(['is_used' => $is_used])) {
            $this->success('成功!');
        }

        $this->error('失败');
    }
}
