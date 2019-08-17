<?php
namespace app\admin\controller;

use app\admin\controller\Base;
use app\admin\model\Role as RoleModel;
use app\admin\model\Rule as RuleModel;
use think\Db;

class Role extends Base
{
    /**
     * 管理员角色
     *
     * @return \think\Response
     */
    public function index()
    {
        $data = Db::name('role')->order('id', 'asc')->paginate(14);
        //获取分页显示
        $page = $data->render();
        $list = $data->items();
        $this->assign('list', $list);
        $this->assign('page', $page);
        $this->assign('list', $list);
        return $this->fetch();
    }

    /**
     * 角色添加
     *
     * @return \think\Response
     */
    public function add()
    {
        $request = request();

        if ($request->method() === 'POST') {

            //1、接收
            $post = $request->post();

            //2、验证数据
            $res = $this->validate($post, 'role');
            if ($res !== true) {
                $this->error($res);
            }

            //3、入库
            $data       = $request->only('role_name,role_desc');
            $role_model = new RoleModel();
            if ($role_model->save($data)) {
                $this->success('添加成功');
            }

        }

        return $this->fetch();
    }

    /**
     * 角色编辑.
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function edit($id)
    {
        $id      = (int) $id;
        $request = request();

        if ($request->method() === 'POST') {

            //1、接收
            $post = $request->post();

            //2、验证数据
            $res = $this->validate($post, 'role');
            if ($res !== true) {
                $this->error($res);
            }

            //3、入库
            $data       = $request->only('role_name,role_desc');
            $role_model = new RoleModel();
            if ($role_model->save($data, ['id' => $id])) {
                $this->success('添加成功');
            }
        }

        $info = Db::name('role')->field('role_name,role_desc')->find($id);

        $this->assign('info', $info);
        $this->assign('url', request()->path());
        return $this->fetch();
    }

    /**
     * 角色删除
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function delete($id = null)
    {
        $id = (int) $id;

        if (empty($id)) {
            $id = input('post.ids');
        }

        $res = true;
        Db::startTrans();
        try {
            Db::name('Role')->whereIn('id', $id)->delete();
            Db::name('RoleRule')->whereIn('role_id', $id)->delete();
            Db::commit();
        } catch (\Exception $e) {
            Db::rollback();
            $res = false;
        }

        if ($res) {
            $this->success('成功!');
        }

        $this->error('失败!');
    }

    /**
     * 权限配置
     * @return [type] [description]
     */
    public function permissionConfig($id)
    {
        $id      = (int) $id;
        $request = request();

        //读取这个角色的所有权限
        $permission_list = Db::name('RoleRule')->field('rule_id')->where(['role_id' => $id])->column('rule_id');

        if ($request->isPost()) {

            //1、接收
            $post = $request->post();

            //读取这个角色拥有的权限(集合A) 和接收到的权限(集合B)，   相同的不碰，两个集合的差集 ， 做删除和添加。

            $ids = $post['ids']; //集合B
            $add = array_diff($ids, $permission_list); //待添加
            $del = array_diff($permission_list, $ids); //待删除

            //待优化，这里可以使用事务实现
            if (!empty($del)) {
                Db::name('RoleRule')->where(['role_id' => $id, 'rule_id' => $del])->delete();
            }

            if (!empty($add)) {
                $add_arr = [];
                foreach ($add as $val) {
                    $add_arr[] = ['role_id' => $id, 'rule_id' => $val];
                }
                Db::name('RoleRule')->insertAll($add_arr);
            }

            $this->success('成功');
        }

        //读取系统的里面全部的权限:
        $rule      = new RuleModel();
        $rule_list = $rule->getRule();

        $this->assign('permission_list', json_encode($permission_list));
        $this->assign('rule_list', $rule_list);
        return $this->fetch();
    }
}
