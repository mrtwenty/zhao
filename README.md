# zhao
基于thinkphp5.1框架和vue做的一个RBAC后台。

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
1. topthink/framework  thinkphp框架
2. topthink/think-captcha thinkphp框架的验证码
3. zoujingli/ip2region ip地址库
4. naixiaoxin/think-wechat  一个微信扩展包
5. aliyuncs/oss-sdk-php  阿里云oss包
6. qiniu/php-sdk         七牛云包
7. mrgoon/aliyun-sms     阿里云短信包

