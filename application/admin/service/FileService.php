<?php
namespace app\admin\service;

use app\admin\library\Oss;
use app\admin\library\Qiniu;
use traits\controller\Jump;

class FileService
{

    use Jump;
    private $file;
    private $config;

    public function __construct($file, $config)
    {
        $this->file   = $file;
        $this->config = $config;
    }

    public function local($dir)
    {

        $info = $this->file->move('uploads/' . $dir . '/');
        if ($info) {
            $this->success('上传成功!', '', $dir . '/' . $info->getSaveName());
        } else {
            $this->error($file->getError()); // 上传失败获取错误信息
        }
    }

    /**
     * 开发中
     * @param  [type] $dir [description]
     * @return [type]      [description]
     */
    public function qiniu($dir)
    {
        $config = $this->config['qiniu'];
    }

    public function oss($dir)
    {
        //配置参数
        $config = $this->config['oss'];

        //生成文件名
        $extension = strtolower(pathinfo($this->file->getInfo('name'), PATHINFO_EXTENSION));
        $filename  = mt_rand(10, 99) . substr(microtime(), 2, 6) . substr(time(), 4, 6);
        $filename .= '.' . $extension;

        $object = $this->file->getInfo('tmp_name');
        $oss    = new Oss($config);

        $file = 'upload/' . $dir . '/' . $filename;

        $msg = $oss->upload($file, $object);

        if ($msg !== true) {
            $this->error($msg);
        }

        $this->success('上传成功!', '', $dir . '/' . $filename);
    }
}
