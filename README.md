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
        <td>topthink/think-captcha | thinkphp框架的验证码</td>
        <td></td>
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