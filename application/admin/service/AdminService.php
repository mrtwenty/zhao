<?php
namespace app\admin\service;

use app\admin\model\Admin;
use app\admin\model\AdminRole;
use app\admin\service\Base;
use think\Db;

class AdminService extends Base
{
    /**
     * 获取当前登录用户所拥有的权限id集合
     * @return [type] [description]
     */
    public function getPermissionList()
    {
        $admin_id = session('admin_id');

        //获取用户的角色，通过角色获取用户拥有的权限。
        $role_list = Db::name('AdminRole')->field('role_id')->where('admin_id', $admin_id)->column('role_id');

        //获取角色列表的权限
        return Db::name('RoleRule')->distinct(true)->field('rule_id')->whereIn('role_id', $role_list)->column('rule_id');
    }

    /**
     * 获取管理员ID所拥有的角色名
     * @return [type] [description]
     */
    public function getAdminRoleNameList($admin_id)
    {
        $admin_role_list = Db::name('AdminRole')->field('id')->where(['admin_id' => $admin_id])->column('role_id');
        return Db::name('Role')->field('role_name')->whereIn('id', $admin_role_list)->column('role_name');
    }

    /**
     * 添加一个管理员
     * @return [type] [description]
     */
    public function insertAdmin($post)
    {
        $res = true;
        Db::startTrans();
        try {
            //1、
            $data               = request()->only(['is_used', 'username', 'password']);
            $data['created_ip'] = request()->ip(1);
            $data['created_at'] = time();
            $admin_model        = Admin::create($data);

            //2、
            $role_list = (array) input('post.role_id', []);
            $data2     = ['admin_id' => $admin_model->id];
            foreach ($role_list as $val) {
                $data2['role_id'] = intval($val);
                Db::name('AdminRole')->insert($data2);
            }

            Db::commit();
        } catch (\Exception $e) {
            // var_dump($e->getmessage()); //调试
            Db::rollback();
            $res = false;
        }

        if ($res) {
            $this->success('添加成功!');
        }

        $this->error('失败!');
    }

    public function updateAdmin($post, $id)
    {

        $res         = true;
        $admin_model = Admin::get($id);
        $admin_model->startTrans();
        try {

            //事务1
            $admin_model->is_used = $post['is_used'];
            $admin_model->updatePassword($post['password']);
            $admin_model->save();

            //事务2 删除当前用户的角色ID
            $ids = input('post.role_id', []); //集合B

            $admin_role = AdminRole::where('admin_id', $id)->column('role_id');

            $add = array_diff($ids, $admin_role); //待添加
            $del = array_diff($admin_role, $ids); //待删除

            if (!empty($del)) {
                AdminRole::where(['admin_id' => $id, 'role_id' => $del])->delete();
            }

            if (!empty($add)) {
                $add_arr = [];
                foreach ($add as $val) {
                    $add_arr[] = ['admin_id' => $id, 'role_id' => $val];
                }
                AdminRole::insertAll($add_arr);
            }

            $admin_model->commit();

        } catch (\Exception $e) {

            $admin_model->rollback();
            $res = false;
        }

        if ($res) {
            $this->success('修改成功!');
        }

        $this->error('失败!');
    }

    public function deleteAdmin($id)
    {
        $res = true;
        Db::startTrans();
        try {
            //1、存放到删除表 admin_del里
            $list = Db::name('admin')->where('id', 'in', $id)->select();

            foreach ($list as $info) {
                Db::name('adminDel')->insert($info);
            }

            //2、删除 admin表的管理员
            Db::name('admin')->whereIn('id', $id)->delete();

            //3、删除 admin_role 里面的 记录
            Db::name('AdminRole')->whereIn('admin_id', $id)->delete();

            Db::commit();
        } catch (\Exception $e) {
            // echo($e->getmessage()); //调试
            Db::rollback();
            $res = false;
        }

        if ($res) {
            $this->success('成功!');
        }
        $this->error('失败!');
    }
}
