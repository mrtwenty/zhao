<?php
namespace app\admin\library;

use OSS\Core\MimeTypes;
use OSS\OssClient;
use OSS\Core\OssException;

class Oss{

    private $ossClient;
    private $bucket;
    private $expires;

    public function __construct($config)
    {   
        $accessKeyId     = $config['accesskey'];
        $accessKeySecret = $config['secretkey'];
    
        $endpoint        = "http://".$config['endpoint'];   //走内网

        $this->expires   = 3600*24*365;  //秒数, 设置缓存时间为一年
        $this->bucket    =  $config['bucket'];
        

        try {
            $this->ossClient = new OssClient($accessKeyId, $accessKeySecret, $endpoint);
        } catch (OssException $e) {
            print $e->getMessage();
            exit;
        }
        
    }
    
    /**
     * 上传
     * @return [type] [description]
     */
    public function upload($object,$file)
    {

        $expires = $this->expires;
        $options['Content-Type'] = MimeTypes::getMimetype($object);
        $options["headers"]      = array ('Cache-control' => 'max-age='.$expires, 
                                          'Expires' => date('D, d M Y H:i:s', time() + $expires) . ' GMT'); 

        try{
            $this->ossClient->uploadFile($this->bucket, $object, $file,$options);
        } catch(OssException $e) {
            return $e->getMessage();
        }

        return true;
    }


     /**
     * 列出Bucket内所有目录和文件， 根据返回的nextMarker循环调用listObjects接口得到所有文件和目录
     *
     * $res1=olists('uploads/banner/201703/','','/',3);
     * $res2=olists('uploads/banner/201703/',$res1['nextMarker'],'/',20);
     * @param $prefix 你要列出的文件所在的目录名
     * @param $nextMarker 从上一次listObjects读到的最后一个文件的下一个文件开始继续获取文件列表
     * @param $delimiter 为行使文件夹功能的分割符号，如 /
     * @param $maxkeys max-keys用于限定此次返回object的最大数
     */
    public function olists($prefix,$nextMarker='',$delimiter='/',$maxkeys=30)
    {
        $options = array(
            'delimiter' => $delimiter,
            'prefix' => $prefix,
            'max-keys' => $maxkeys,
            'marker' => $nextMarker,
        );
        try {
            $listObjectInfo = $this->ossClient->listObjects($this->bucket, $options);
        } catch (OssException $e) {
            return $e->getMessage();
        }
        // 得到nextMarker，从上一次listObjects读到的最后一个文件的下一个文件开始继续获取文件列表
        $nextMarker = $listObjectInfo->getNextMarker();
        $listObject = $listObjectInfo->getObjectList();
        $listPrefix = $listObjectInfo->getPrefixList();
        $list = array();
        $list['nextMarker'] = $nextMarker;
        foreach($listObject as $info){

            $list['file'][] = array(
                    'name' => $info->getKey(),
                    'type' => MimeTypes::getMimetype($info->getKey()),
                );
        }
        foreach($listPrefix as $info){
            $list['dir'][] = array('name' => $info->getPrefix());
        }
        return $list;
    }

    /**
     * 设置缓存
     */
    public function setCache($file)
    {
        
        $expires = $this->expires;//秒数

        $upload_file_options["headers"] = array ('Cache-control' => 'max-age='.$expires,
                                             'Expires' => date('D, d M Y H:i:s', time() + $expires) . ' GMT');

        $upload_file_options['Content-Type']=MimeTypes::getMimetype($file);
    
        $this->ossClient->copyObject($this->bucket,$file,$this->bucket, $file,$upload_file_options);
    }

}
