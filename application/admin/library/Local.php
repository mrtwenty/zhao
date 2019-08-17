<?php
namespace app\admin\library;

class Local
{


    public function upload($dir,$savename,$content)
    {
        
        if(!$this->checkPath($dir)){
            return false;
        }
        
        $filename=$dir.'/'.$savename;
        file_put_contents($filename,$content);
        
        return true;
    }

    /**
     * 检查目录是否可写
     * @access protected
     * @param  string   $path    目录
     * @return boolean
     */
    protected function checkPath($path)
    {
        if (is_dir($path)) {
            return true;
        }

        if (mkdir($path, 0755, true)) {
            return true;
        }

        $this->error = ['directory {:path} creation failed', ['path' => $path]];
        return false;
    }
}


// 说明，暂时不考虑场景二维码的图片处理。
// use app\admin\library\Local;
// $dir=env('root_path').'public/uploads/qrcode/'.date('Ym').'/';
// $url = $this->weixin->qrcode->url($result['ticket']);
// $content=file_get_contents($url);

// $local=new Local();
// $local->upload($dir,md5('123').'.jpg',$content);