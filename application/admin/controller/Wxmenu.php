<?php
namespace app\admin\controller;

use app\admin\controller\Base;
use app\admin\service\WxService;
use think\Db;

/**
 * 微信菜单管理
 */
class Wxmenu extends Base
{

    private $menu;

    protected function initialize()
    {
        parent::initialize();
        $app        = new WxService();
        $this->menu = $app->getMenu();
    }

    /**
     * 微信菜单的类型
     * @var array
     */
    protected $menuType = [
        'view'               => '跳转URL',
        'click'              => '点击推事件',
        'scancode_push'      => '扫码推事件',
        'scancode_waitmsg'   => '扫码推事件且弹出“消息接收中”提示框',
        'pic_sysphoto'       => '弹出系统拍照发图',
        'pic_photo_or_album' => '弹出拍照或者相册发图',
        'pic_weixin'         => '弹出微信相册发图器',
        'location_select'    => '弹出地理位置选择器',
    ];

    public function index()
    {
        $request = request();
        if ($request->isPost()) {

            $post = $request->post();

            !isset($post['data']) && $this->error('访问出错，请稍候再试！');

            // 删除菜单
            if (empty($post['data'])) {
                try {
                    Db::name('WxMenu')->where('1=1')->delete();
                    $this->menu->delete();
                } catch (\Exception $e) {
                    $this->error('删除取消微信菜单失败，请稍候再试！' . $e->getMessage());
                }

                $this->success('删除并取消微信菜单成功！', '');
            }

            // 数据过滤处理
            try {

                foreach ($post['data'] as &$vo) {
                    isset($vo['content']) && ($vo['content'] = str_replace('"', "'", $vo['content']));
                }

                Db::name('WxMenu')->where('1=1')->delete();
                foreach ($post['data'] as $item) {
                    $item['created_at'] = time();
                    Db::name('WxMenu')->insert($item);
                }

                $this->_push();

            } catch (\Exception $e) {
                $this->error('微信菜单发布失败，请稍候再试！' . $e->getMessage());
            }
            $this->success('保存发布菜单成功！');
        }

        $list = Db::name('WxMenu')->select();
        $this->assign('list', $this->arr2tree($list, 'index', 'pindex'));
        return $this->fetch();
    }

    /**
     * 取消菜单
     */
    public function cancel()
    {

        try {
            $this->menu->delete();
        } catch (\Exception $e) {
            $this->error('菜单取消失败');
        }
        $this->success('菜单取消成功，重新关注可立即生效！', '');
    }

    /**
     * 菜单推送
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @throws \WeChat\Exceptions\LocalCacheException
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    private function _push()
    {

        $field  = 'id,index,pindex,name,type,content';
        $result = (array) Db::name('WxMenu')->field($field)->order('sort ASC,id ASC')->select();
        foreach ($result as &$row) {
            empty($row['content']) && $row['content'] = uniqid();
            if ($row['type'] === 'miniprogram') {
                list($row['appid'], $row['url'], $row['pagepath']) = explode(',', "{$row['content']},,");
            } elseif ($row['type'] === 'view') {
                if (preg_match('#^(\w+:)?//#', $row['content'])) {
                    $row['url'] = $row['content'];
                } else {
                    $row['url'] = url($row['content'], '', true, true);
                }
            } elseif ($row['type'] === 'event') {
                if (isset($this->menuType[$row['content']])) {
                    list($row['type'], $row['key']) = [$row['content'], "wechat_menu#id#{$row['id']}"];
                }
            } elseif ($row['type'] === 'media_id') {
                $row['media_id'] = $row['content'];
            } else {
                $row['key']                                              = "wechat_menu#id#{$row['id']}";
                !in_array($row['type'], $this->menuType) && $row['type'] = 'click';
            }
            unset($row['content']);
        }
        $menus = $this->arr2tree($result, 'index', 'pindex', 'sub_button');
        //去除无效的字段
        foreach ($menus as &$menu) {
            unset($menu['index'], $menu['pindex'], $menu['id']);
            if (empty($menu['sub_button'])) {
                continue;
            }
            foreach ($menu['sub_button'] as &$submenu) {
                unset($submenu['index'], $submenu['pindex'], $submenu['id']);
            }
            unset($menu['type']);
        }

        $this->menu->create($menus);
    }

    /**
     * 一维数据数组生成数据树
     * @param array $list 数据列表
     * @param string $id 父ID Key
     * @param string $pid ID Key
     * @param string $son 定义子数据Key
     * @return array
     */
    public static function arr2tree($list, $id = 'id', $pid = 'pid', $son = 'sub')
    {
        list($tree, $map) = [[], []];
        foreach ($list as $item) {
            $map[$item[$id]] = $item;
        }
        foreach ($list as $item) {
            if (isset($item[$pid]) && isset($map[$item[$pid]])) {
                $map[$item[$pid]][$son][] = &$map[$item[$id]];
            } else {
                $tree[] = &$map[$item[$id]];
            }
        }
        unset($map);
        return $tree;
    }
}
