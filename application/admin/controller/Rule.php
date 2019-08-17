<?php

namespace app\admin\controller;

use app\admin\controller\Base;
use app\admin\model\Rule as RuleModel;
use think\Db;
use think\Request;

class Rule extends Base
{
    /**
     * 权限规则管理
     */
    public function index()
    {
        $rule_model = new RuleModel();
        $tree       = $rule_model->getRule();

        $this->assign('tree', $tree);
        return $this->fetch();
    }

    /**
     * 权限规则添加
     */
    public function add()
    {
        $request = request();

        if ($request->isPost()) {

            //接收
            $controller = input('post.controller');

            //验证:
            // in_array 判断 不能是 Auth Rule Admin 控制器 其他都行。
            if (in_array($controller, ['Auth', 'Rule', 'Admin'])) {
                $this->error('提交的控制器不能修改。');
            }

            //判断这个控制器文件是否存在
            $file = __DIR__ . $controller . ".php";
            if (!file_exists($file)) {
                $this->error('该控制器不存在');
            }

            //1、反射:
            $class_name = 'app\\admin\\controller\\' . $controller;
            $reflection = new \ReflectionClass($class_name);

            //2、通过反射获取类的注释
            //$doc = $reflection->getDocComment ();

            //3、获取各个公共方法和其注释
            $method_arr = [];
            $methods    = $reflection->getMethods(\ReflectionMethod::IS_PUBLIC);
            foreach ($methods as $method) {
                if ($method->name === '__construct') {
                    continue;
                }

                $doc = $method->getDocComment(); //获取方法的注释
                preg_match_all('#\* (.*)#', $doc, $arr);
                $method_arr[$method->name] = $arr[1][0];
            }

            //index
            $index = [
                'parent_id' => 1, 'rule_desc' => $method_arr['index'], 'rule_url' => get_rule_url($controller, 'index'),
            ];

            $pid = Db::name('Rule')->insertGetId($index);

            //other
            unset($method_arr['index']);
            foreach ($method_arr as $k => $v) {
                $temp = [
                    'parent_id' => $pid, 'rule_desc' => $v, 'rule_url' => get_rule_url($controller, $k),
                ];

                Db::name('Rule')->insert($temp);
            }

            $this->success('成功');

        }

        return $this->fetch();
    }

    /**
     * 权限规则编辑
     */
    public function edit($id)
    {
        $id      = (int) $id;
        $request = request();

        if ($request->isPost()) {

            $post = $request->post();

            $msg = $this->validate($post, 'rule.edit');
            if ($msg !== true) {
                $this->error($msg);
            }

            $data = $request->only(['rule_name', 'rule_desc']);
            Db::name('rule')->where('id', $id)->update($data);
            $this->success('成功!', url('rule/index'));
        }

        $info = Db::name('rule')->find($id);

        $this->assign('info', $info);
        return $this->fetch();
    }

    /**
     * 权限规则删除
     */
    public function delete()
    {
        $ids = input('post.ids', '');

        if (empty($ids)) {
            $this->error('参数不对');
        }

        $stop   = [];
        $delete = [];

        foreach ($ids as $val) {

            if (in_array($val, $stop)) {
                continue;
            }

            // 先查询自己是不是顶级，如果是parent_id 则不删除
            if (!Db::name('Rule')->where('id', $val)->value('parent_id')) {
                continue;
            }

            // 查询自己下面还有没有下级，如果没有，就删除自己
            $son = Db::name('Rule')->where('parent_id', $val)->column('id');
            if (empty($son)) {
                $delete[] = $val;
                continue;
            }

            //到了这里就表示这个 $val 下面有子集合，判断下是否都在待删除的集合里。
            $res = array_diff($son, $ids); //差集,差集的作用在于判断父级是否要删除

            if (empty($res)) {
                //全部都在集合里，可以删除自己和son
                $son[]  = $val;
                $delete = array_merge($delete, $son);
                $stop   = array_merge($stop, $son);
                continue;
            }

            //到了这里就表示，$val下的集合，不是全部要删除，只是删除子集合中的某个
            $res3   = array_intersect($ids, $son); //交集,交集的作用在于把子集合里面要删除的，顺带删除了。
            $stop   = array_merge($stop, $res3);
            $delete = array_merge($delete, $res3);
        }

        if (!empty($delete)) {

            Db::name('Rule')->delete($delete);
            Db::name('RoleRule')->whereIn('rule_id', $delete)->delete();
        }

        $this->success('成功!');
    }
}

/*
INSERT INTO `zhao`.`z_rule` (`id`, `rule_url`, `parent_id`, `rule_desc`) VALUES ('42', '', '0', '会员模块');
INSERT INTO `zhao`.`z_rule` (`id`, `rule_url`, `parent_id`, `rule_desc`) VALUES ('43', 'member/index', '42', '会员列表');
INSERT INTO `zhao`.`z_rule` (`id`, `rule_url`, `parent_id`, `rule_desc`) VALUES ('47', 'member_level/index', '42', '会员等级');
INSERT INTO `zhao`.`z_rule` (`id`, `rule_url`, `parent_id`, `rule_desc`) VALUES ('51', 'member_login_log/index', '42', '会员登录日志');

INSERT INTO `zhao`.`z_rule` (`id`, `rule_url`, `parent_id`, `rule_desc`) VALUES ('44', 'member/add', '43', '会员添加');
INSERT INTO `zhao`.`z_rule` (`id`, `rule_url`, `parent_id`, `rule_desc`) VALUES ('45', 'member/edit', '43', '会员编辑');
INSERT INTO `zhao`.`z_rule` (`id`, `rule_url`, `parent_id`, `rule_desc`) VALUES ('46', 'member/delete', '43', '会员删除');
INSERT INTO `zhao`.`z_rule` (`id`, `rule_url`, `parent_id`, `rule_desc`) VALUES ('52', 'member/usedstatus', '43', '会员状态');

INSERT INTO `zhao`.`z_rule` (`id`, `rule_url`, `parent_id`, `rule_desc`) VALUES ('48', 'member_level/add', '47', '等级添加');
INSERT INTO `zhao`.`z_rule` (`id`, `rule_url`, `parent_id`, `rule_desc`) VALUES ('49', 'member_level/edit', '47', '等级编辑');
INSERT INTO `zhao`.`z_rule` (`id`, `rule_url`, `parent_id`, `rule_desc`) VALUES ('50', 'member_level/delete', '47', '等级删除');

INSERT INTO `zhao`.`z_rule` (`id`, `rule_url`, `parent_id`, `rule_desc`) VALUES ('13', 'rule/index', '1', '权限管理');
INSERT INTO `zhao`.`z_rule` (`id`, `rule_url`, `parent_id`, `rule_desc`) VALUES ('16', 'rule/add', '13', '权限添加');
INSERT INTO `zhao`.`z_rule` (`id`, `rule_url`, `parent_id`, `rule_desc`) VALUES ('21', 'rule/edit', '13', '权限编辑');
INSERT INTO `zhao`.`z_rule` (`id`, `rule_url`, `parent_id`, `rule_desc`) VALUES ('22', 'rule/delete', '13', '权限删除');
短信:
INSERT INTO `zhao`.`z_rule` (`id`, `rule_url`, `parent_id`, `rule_desc`) VALUES ('27', 'sms_log/index', '1', '短信日志');
INSERT INTO `zhao`.`z_rule` (`id`, `rule_url`, `parent_id`, `rule_desc`) VALUES ('28', 'sms_log/look', '27', '发送结果');
 */
