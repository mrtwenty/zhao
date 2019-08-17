# zhao
基于thinkphp5.1框架和layui做的一个RBAC后台。

## 安装步骤
1. git 拉取项目
2. composer install
3. 导入项目根目录下的数据库文件zhao.sql
4. 编写一个.env文件，里面写上:
```
ENVIRONMENT=development
DATABASE_HOST='127.0.0.1'
DATABASE_USER=root
DATABASE_PWD=123456
DATABASE_DB=zhao
APP_DEBUG=1
APP_TRACE=1
```
5. 创建虚拟主机，web服务器nginx配置如下
```
server {
    listen       80;
    server_name  zhao.com;
    root         "project path/public/";
    autoindex    on;
    index        index.php index.html index.htm;
    
    location / {
      if (!-e $request_filename) {
        rewrite  ^(.*)$  /index.php?s=/$1  last;
        break;
       }
    }
    
    location  ~ [^/]\.php(/|$) {
        fastcgi_split_path_info  ^(.+?\.php)(/.*)$;
        if (!-f $document_root$fastcgi_script_name) {
                return 404;
        }
        fastcgi_pass   127.0.0.1:9002;
        fastcgi_index  index.php;
        fastcgi_param  SCRIPT_FILENAME  $document_root$fastcgi_script_name;
        fastcgi_param  PATH_INFO        $fastcgi_path_info;
        fastcgi_param  PATH_TRANSLATED  $document_root$fastcgi_path_info;
        include        fastcgi_params;
    }
}
```


## 项目相关的依赖包
<table>
    <tr>
        <th>包名</th>
        <th>介绍</th>
    </tr>
    <tr>
        <td>topthink/framework</td>
        <td>thinkphp框架</td>
    </tr>
    <tr>
        <td>topthink/think-captcha</td>
        <td>thinkphp框架的验证码</td>
    </tr>
    <tr>
        <td>zoujingli/ip2region</td>
        <td>ip地址库</td>
    </tr>
    <tr>
        <td>naixiaoxin/think-wechat</td>
        <td>一个微信扩展包</td>
    </tr>
    <tr>
        <td>aliyuncs/oss-sdk-php</td>
        <td>阿里云oss包</td>
    </tr>
    <tr>
        <td>qiniu/php-sdk</td>
        <td>七牛云包</td>
    </tr>
    <tr>
        <td>mrgoon/aliyun-sms</td>
        <td>阿里云短信包</td>
    </tr>
</table>