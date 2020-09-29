/*
Navicat MySQL Data Transfer

Source Server         : 本地
Source Server Version : 50723
Source Host           : 127.0.0.1:3306
Source Database       : hehe

Target Server Type    : MYSQL
Target Server Version : 50723
File Encoding         : 65001

Date: 2020-09-29 09:56:04
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for z_admin
-- ----------------------------
DROP TABLE IF EXISTS `z_admin`;
CREATE TABLE `z_admin` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT '管理员ID',
  `username` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '用户名',
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '密码',
  `created_ip` int(11) unsigned NOT NULL COMMENT '创建该管理员的时候的IP',
  `created_at` int(11) unsigned NOT NULL COMMENT '创建时间',
  `is_used` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否启用 0表示启用 1表示禁用',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='管理员表';

-- ----------------------------
-- Records of z_admin
-- ----------------------------
INSERT INTO `z_admin` VALUES ('1', 'admin', '$2y$10$Eno2.nmJxhTx69TvVxx4PObbh05FMjntax2wS7VbendcbexE4W3ZG', '2130706433', '1533287058', '0');

-- ----------------------------
-- Table structure for z_admin_action_log
-- ----------------------------
DROP TABLE IF EXISTS `z_admin_action_log`;
CREATE TABLE `z_admin_action_log` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT '日志ID',
  `admin_id` smallint(6) unsigned NOT NULL COMMENT '管理员ID',
  `method` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '请求方法',
  `url` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '请求地址',
  `params` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '请求参数序列化',
  `created_at` int(11) unsigned NOT NULL COMMENT '录入时间',
  `ip` int(11) unsigned NOT NULL COMMENT '请求IP',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11257 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='管理员操作日志表';

-- ----------------------------
-- Records of z_admin_action_log
-- ----------------------------
INSERT INTO `z_admin_action_log` VALUES ('11234', '1', 'GET', 'admin/index/index.html', 'a:2:{s:3:\"get\";a:0:{}s:4:\"post\";a:0:{}}', '1601343858', '2130706433');
INSERT INTO `z_admin_action_log` VALUES ('11235', '1', 'GET', 'admin/index/welcome.html', 'a:2:{s:3:\"get\";a:0:{}s:4:\"post\";a:0:{}}', '1601343859', '2130706433');
INSERT INTO `z_admin_action_log` VALUES ('11236', '1', 'GET', 'admin/config/index.html', 'a:2:{s:3:\"get\";a:0:{}s:4:\"post\";a:0:{}}', '1601343862', '2130706433');
INSERT INTO `z_admin_action_log` VALUES ('11237', '1', 'GET', 'admin/sms_log/index.html', 'a:2:{s:3:\"get\";a:0:{}s:4:\"post\";a:0:{}}', '1601343863', '2130706433');
INSERT INTO `z_admin_action_log` VALUES ('11238', '1', 'GET', 'admin/role/index.html', 'a:2:{s:3:\"get\";a:0:{}s:4:\"post\";a:0:{}}', '1601343864', '2130706433');
INSERT INTO `z_admin_action_log` VALUES ('11239', '1', 'GET', 'admin/admin/index.html', 'a:2:{s:3:\"get\";a:0:{}s:4:\"post\";a:0:{}}', '1601343864', '2130706433');
INSERT INTO `z_admin_action_log` VALUES ('11240', '1', 'GET', 'admin/role/permissionconfig/id/1.html', 'a:2:{s:3:\"get\";a:0:{}s:4:\"post\";a:0:{}}', '1601343868', '2130706433');
INSERT INTO `z_admin_action_log` VALUES ('11241', '1', 'GET', 'admin/role/index.html', 'a:2:{s:3:\"get\";a:0:{}s:4:\"post\";a:0:{}}', '1601343870', '2130706433');
INSERT INTO `z_admin_action_log` VALUES ('11242', '1', 'GET', 'admin/role/add.html', 'a:2:{s:3:\"get\";a:0:{}s:4:\"post\";a:0:{}}', '1601343872', '2130706433');
INSERT INTO `z_admin_action_log` VALUES ('11243', '1', 'GET', 'admin/role/index.html', 'a:2:{s:3:\"get\";a:0:{}s:4:\"post\";a:0:{}}', '1601343873', '2130706433');
INSERT INTO `z_admin_action_log` VALUES ('11244', '1', 'GET', 'admin/role/add.html', 'a:2:{s:3:\"get\";a:0:{}s:4:\"post\";a:0:{}}', '1601343880', '2130706433');
INSERT INTO `z_admin_action_log` VALUES ('11245', '1', 'GET', 'admin/role/add.html', 'a:2:{s:3:\"get\";a:0:{}s:4:\"post\";a:0:{}}', '1601343945', '2130706433');
INSERT INTO `z_admin_action_log` VALUES ('11246', '1', 'GET', 'admin/role/index.html', 'a:2:{s:3:\"get\";a:0:{}s:4:\"post\";a:0:{}}', '1601343947', '2130706433');
INSERT INTO `z_admin_action_log` VALUES ('11247', '1', 'GET', 'admin/admin/add.html', 'a:2:{s:3:\"get\";a:0:{}s:4:\"post\";a:0:{}}', '1601343949', '2130706433');
INSERT INTO `z_admin_action_log` VALUES ('11248', '1', 'GET', 'admin/admin/index.html', 'a:2:{s:3:\"get\";a:0:{}s:4:\"post\";a:0:{}}', '1601343950', '2130706433');
INSERT INTO `z_admin_action_log` VALUES ('11249', '1', 'GET', 'admin/admin_login_log/index.html', 'a:2:{s:3:\"get\";a:0:{}s:4:\"post\";a:0:{}}', '1601343961', '2130706433');
INSERT INTO `z_admin_action_log` VALUES ('11250', '1', 'GET', 'admin/admin_login_log/index.html', 'a:2:{s:3:\"get\";a:0:{}s:4:\"post\";a:0:{}}', '1601343962', '2130706433');
INSERT INTO `z_admin_action_log` VALUES ('11251', '1', 'GET', 'admin/config/uploads.html', 'a:2:{s:3:\"get\";a:0:{}s:4:\"post\";a:0:{}}', '1601344141', '2130706433');
INSERT INTO `z_admin_action_log` VALUES ('11252', '1', 'GET', 'admin/config/uploads.html', 'a:2:{s:3:\"get\";a:0:{}s:4:\"post\";a:0:{}}', '1601344384', '2130706433');
INSERT INTO `z_admin_action_log` VALUES ('11253', '1', 'GET', 'admin/config/uploads.html', 'a:2:{s:3:\"get\";a:0:{}s:4:\"post\";a:0:{}}', '1601344452', '2130706433');
INSERT INTO `z_admin_action_log` VALUES ('11254', '1', 'GET', 'admin/config/index.html', 'a:2:{s:3:\"get\";a:0:{}s:4:\"post\";a:0:{}}', '1601344498', '2130706433');
INSERT INTO `z_admin_action_log` VALUES ('11255', '1', 'GET', 'admin/sms_log/index.html', 'a:2:{s:3:\"get\";a:0:{}s:4:\"post\";a:0:{}}', '1601344499', '2130706433');
INSERT INTO `z_admin_action_log` VALUES ('11256', '1', 'GET', 'admin/role/index.html', 'a:2:{s:3:\"get\";a:0:{}s:4:\"post\";a:0:{}}', '1601344499', '2130706433');

-- ----------------------------
-- Table structure for z_admin_login_log
-- ----------------------------
DROP TABLE IF EXISTS `z_admin_login_log`;
CREATE TABLE `z_admin_login_log` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '日志ID',
  `admin_id` smallint(5) unsigned NOT NULL COMMENT '管理员ID',
  `ip` int(11) unsigned NOT NULL COMMENT '登录IP',
  `created_at` int(11) unsigned NOT NULL COMMENT '登录时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=104 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='管理员日志表';

-- ----------------------------
-- Records of z_admin_login_log
-- ----------------------------
INSERT INTO `z_admin_login_log` VALUES ('103', '1', '2130706433', '1601343857');

-- ----------------------------
-- Table structure for z_admin_role
-- ----------------------------
DROP TABLE IF EXISTS `z_admin_role`;
CREATE TABLE `z_admin_role` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `admin_id` smallint(5) unsigned NOT NULL COMMENT '管理员ID',
  `role_id` smallint(5) unsigned NOT NULL COMMENT '角色ID',
  PRIMARY KEY (`id`),
  UNIQUE KEY `admin_role` (`admin_id`,`role_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='管理员与角色表关系表';

-- ----------------------------
-- Records of z_admin_role
-- ----------------------------
INSERT INTO `z_admin_role` VALUES ('37', '1', '1');
INSERT INTO `z_admin_role` VALUES ('38', '1', '2');
INSERT INTO `z_admin_role` VALUES ('39', '1', '3');
INSERT INTO `z_admin_role` VALUES ('40', '11', '1');
INSERT INTO `z_admin_role` VALUES ('41', '11', '2');
INSERT INTO `z_admin_role` VALUES ('42', '11', '3');
INSERT INTO `z_admin_role` VALUES ('43', '11', '4');

-- ----------------------------
-- Table structure for z_config
-- ----------------------------
DROP TABLE IF EXISTS `z_config`;
CREATE TABLE `z_config` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT COMMENT '配置ID',
  `c_key` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '配置名',
  `c_value` varchar(5000) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '配置值',
  `c_description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '配置描述',
  `c_type` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '配置类型',
  PRIMARY KEY (`id`),
  UNIQUE KEY `c_key` (`c_key`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='配置表';

-- ----------------------------
-- Records of z_config
-- ----------------------------
INSERT INTO `z_config` VALUES ('1', 'admin_name', 'admin', '后台模块地址名', 'base');
INSERT INTO `z_config` VALUES ('2', 'auth_is_open', '0', '权限认证是否开启  0关闭、1开启', 'base');
INSERT INTO `z_config` VALUES ('3', 'web_close_msg', '关站维护中!', '网站关闭说明', 'base');
INSERT INTO `z_config` VALUES ('4', 'web_count', '统计代码1', '站点统计', 'base');
INSERT INTO `z_config` VALUES ('5', 'web_description', '网站描述', '网站描述', 'base');
INSERT INTO `z_config` VALUES ('6', 'web_icp', '京ICP证030173号', '网站备案号', 'base');
INSERT INTO `z_config` VALUES ('7', 'web_is_open', '1', '网站开关 0关闭、1开启', 'base');
INSERT INTO `z_config` VALUES ('8', 'web_keywords', '关键词', '网站关键词', 'base');
INSERT INTO `z_config` VALUES ('9', 'web_title', '网站标题', '网站标题', 'base');
INSERT INTO `z_config` VALUES ('13', 'upload_is_open', '1', '是否开启文件上传 0关闭、1开启', 'upload');
INSERT INTO `z_config` VALUES ('14', 'upload_ext', 'png,jpg,gif', '文件上传类型', 'upload');
INSERT INTO `z_config` VALUES ('15', 'upload_type', 'local', '文件上传方式  local、oss、qiniu', 'upload');
INSERT INTO `z_config` VALUES ('16', 'upload_params', '{\"oss\":{\"is_https\":\"http\",\"bucket\":\"\",\"endpoint\":\"\",\"accesskey\":\"\",\"secretkey\":\"\"},\"qiniu\":{\"region\":\"\\u534e\\u4e1c\",\"is_https\":\"http\",\"bucket\":\".com\",\"domain\":\"1\",\"accesskey\":\"\",\"secretkey\":\"\"}}', '文件上传相关参数', 'upload');
INSERT INTO `z_config` VALUES ('18', 'web_logo', 'logo1/20180809\\ddea7479fdbf2798610f95bad78cf3cd.jpg', '网站logo', 'base');
INSERT INTO `z_config` VALUES ('19', 'upload_size', '2', '上传大小,单位MB', 'upload');
INSERT INTO `z_config` VALUES ('20', 'ali_sms_access_key', 'LTAIKS2', '阿里云SMS短信 access_key', 'base');
INSERT INTO `z_config` VALUES ('21', 'ali_sms_access_secret', 'GCC5ki12', '阿里云SMS短信 access_secret', 'base');
INSERT INTO `z_config` VALUES ('22', 'ali_sms_sign_name', '陈xx', '阿里云SMS短信 签名', 'base');
INSERT INTO `z_config` VALUES ('23', 'ali_sms_verification_code', 'SMS_140723', '阿里云SMS短信 验证码模板ID', 'base');
INSERT INTO `z_config` VALUES ('24', 'weixin_appid', 'wx4f782', '微信APPID', 'weixin');
INSERT INTO `z_config` VALUES ('25', 'weixin_appsecret', '6f1fd16c5312', '微信APPSECRET', 'weixin');
INSERT INTO `z_config` VALUES ('26', 'weixin_token', 'dazh2', '微信TOKEN', 'weixin');
INSERT INTO `z_config` VALUES ('27', 'default_member_photo', 'avatar/20180821/a785595a6b57031ae97d643f70fcd2c4.jpg', '会员默认头像', 'base');
INSERT INTO `z_config` VALUES ('28', 'baidu_lbs_browser_ak', 'ruz9b4E3cG2', '百度LBS应用浏览器端AK', 'base');
INSERT INTO `z_config` VALUES ('29', 'baidu_lbs_server_ak', 'kae02', '百度LBS应用服务器端AK', 'base');
INSERT INTO `z_config` VALUES ('30', 'weixin_mchid', '15362', '微信支付MCHID', 'weixin');
INSERT INTO `z_config` VALUES ('31', 'weixin_key', '9DVhImiNUhxGaWO2', '微信支付KEY', 'weixin');
INSERT INTO `z_config` VALUES ('46', 'lbs_key', 'H3GBZ-2', '腾讯地图LBS', 'base');
INSERT INTO `z_config` VALUES ('48', 'weixin_applet_appid', 'wx0782', '微信小程序appid', 'weixin');
INSERT INTO `z_config` VALUES ('49', 'weixin_applet_appsecret', '68bd350a8985b02', '微信小程序appsecret', 'weixin');
INSERT INTO `z_config` VALUES ('50', 'ali_sms_shopping_notify', 'SMS_1423', '用户消费短信模板', 'base');

-- ----------------------------
-- Table structure for z_role
-- ----------------------------
DROP TABLE IF EXISTS `z_role`;
CREATE TABLE `z_role` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '角色ID',
  `role_name` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '角色名',
  `role_desc` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '角色描述',
  `created_at` int(11) unsigned NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='角色表';

-- ----------------------------
-- Records of z_role
-- ----------------------------
INSERT INTO `z_role` VALUES ('1', '管理员', '负责所有权限', '1533699440');
INSERT INTO `z_role` VALUES ('2', '技术总监', '负责管理配置权限', '1533023262');
INSERT INTO `z_role` VALUES ('3', '客服', '负责对外的客服妹子', '1533699440');
INSERT INTO `z_role` VALUES ('4', '管理', '管理员2', '1557452521');

-- ----------------------------
-- Table structure for z_role_rule
-- ----------------------------
DROP TABLE IF EXISTS `z_role_rule`;
CREATE TABLE `z_role_rule` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `role_id` smallint(5) unsigned NOT NULL COMMENT '角色ID',
  `rule_id` smallint(5) unsigned NOT NULL COMMENT '规则ID',
  PRIMARY KEY (`id`),
  UNIQUE KEY `role_rule` (`role_id`,`rule_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=411 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='角色规则表';

-- ----------------------------
-- Records of z_role_rule
-- ----------------------------
INSERT INTO `z_role_rule` VALUES ('33', '1', '1');
INSERT INTO `z_role_rule` VALUES ('34', '1', '2');
INSERT INTO `z_role_rule` VALUES ('45', '1', '3');
INSERT INTO `z_role_rule` VALUES ('36', '1', '4');
INSERT INTO `z_role_rule` VALUES ('37', '1', '5');
INSERT INTO `z_role_rule` VALUES ('39', '1', '6');
INSERT INTO `z_role_rule` VALUES ('40', '1', '7');
INSERT INTO `z_role_rule` VALUES ('41', '1', '8');
INSERT INTO `z_role_rule` VALUES ('42', '1', '9');
INSERT INTO `z_role_rule` VALUES ('77', '1', '10');
INSERT INTO `z_role_rule` VALUES ('78', '1', '11');
INSERT INTO `z_role_rule` VALUES ('79', '1', '12');
INSERT INTO `z_role_rule` VALUES ('38', '1', '14');
INSERT INTO `z_role_rule` VALUES ('50', '1', '15');
INSERT INTO `z_role_rule` VALUES ('83', '1', '23');
INSERT INTO `z_role_rule` VALUES ('107', '1', '24');
INSERT INTO `z_role_rule` VALUES ('109', '1', '26');
INSERT INTO `z_role_rule` VALUES ('409', '1', '27');
INSERT INTO `z_role_rule` VALUES ('410', '1', '28');
INSERT INTO `z_role_rule` VALUES ('112', '1', '29');
INSERT INTO `z_role_rule` VALUES ('118', '1', '35');
INSERT INTO `z_role_rule` VALUES ('119', '1', '36');
INSERT INTO `z_role_rule` VALUES ('120', '1', '37');
INSERT INTO `z_role_rule` VALUES ('136', '1', '53');
INSERT INTO `z_role_rule` VALUES ('87', '2', '1');
INSERT INTO `z_role_rule` VALUES ('71', '2', '2');
INSERT INTO `z_role_rule` VALUES ('72', '2', '3');
INSERT INTO `z_role_rule` VALUES ('73', '2', '4');
INSERT INTO `z_role_rule` VALUES ('74', '2', '5');
INSERT INTO `z_role_rule` VALUES ('88', '2', '6');
INSERT INTO `z_role_rule` VALUES ('89', '2', '7');
INSERT INTO `z_role_rule` VALUES ('90', '2', '8');
INSERT INTO `z_role_rule` VALUES ('91', '2', '9');
INSERT INTO `z_role_rule` VALUES ('93', '2', '10');
INSERT INTO `z_role_rule` VALUES ('95', '2', '11');
INSERT INTO `z_role_rule` VALUES ('96', '2', '12');
INSERT INTO `z_role_rule` VALUES ('97', '2', '13');
INSERT INTO `z_role_rule` VALUES ('75', '2', '14');
INSERT INTO `z_role_rule` VALUES ('92', '2', '15');
INSERT INTO `z_role_rule` VALUES ('98', '2', '16');
INSERT INTO `z_role_rule` VALUES ('99', '2', '21');
INSERT INTO `z_role_rule` VALUES ('100', '2', '22');
INSERT INTO `z_role_rule` VALUES ('94', '2', '23');
INSERT INTO `z_role_rule` VALUES ('105', '2', '24');
INSERT INTO `z_role_rule` VALUES ('106', '2', '25');

-- ----------------------------
-- Table structure for z_rule
-- ----------------------------
DROP TABLE IF EXISTS `z_rule`;
CREATE TABLE `z_rule` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT '规则ID',
  `rule_url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '验证规则',
  `parent_id` int(11) unsigned NOT NULL COMMENT '父ID',
  `rule_desc` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '规则描述',
  `sort` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='规则表';

-- ----------------------------
-- Records of z_rule
-- ----------------------------
INSERT INTO `z_rule` VALUES ('1', '', '0', '系统管理', '0');
INSERT INTO `z_rule` VALUES ('2', 'role/index', '1', '管理员角色', '1');
INSERT INTO `z_rule` VALUES ('3', 'role/add', '2', '角色添加', '0');
INSERT INTO `z_rule` VALUES ('4', 'role/edit', '2', '角色编辑', '0');
INSERT INTO `z_rule` VALUES ('5', 'role/delete', '2', '角色删除', '0');
INSERT INTO `z_rule` VALUES ('6', 'admin/index', '1', '管理员', '2');
INSERT INTO `z_rule` VALUES ('7', 'admin/add', '6', '管理员添加', '0');
INSERT INTO `z_rule` VALUES ('8', 'admin/edit', '6', '管理员编辑', '0');
INSERT INTO `z_rule` VALUES ('9', 'admin/delete', '6', '管理员删除', '0');
INSERT INTO `z_rule` VALUES ('10', 'admin_action_log/index', '1', '系统日志', '215');
INSERT INTO `z_rule` VALUES ('11', 'admin_login_log/index', '1', '登录日志', '215');
INSERT INTO `z_rule` VALUES ('12', 'config/index', '1', '系统配置', '0');
INSERT INTO `z_rule` VALUES ('14', 'role/permissionConfig', '2', '配置权限', '0');
INSERT INTO `z_rule` VALUES ('15', 'admin/usedStatus', '6', '管理员状态', '0');
INSERT INTO `z_rule` VALUES ('23', 'admin_action_log/look', '10', '参数查看', '0');
INSERT INTO `z_rule` VALUES ('24', '', '0', '微信模块', '0');
INSERT INTO `z_rule` VALUES ('26', 'config/uploads', '1', '文件存储', '5');
INSERT INTO `z_rule` VALUES ('27', 'sms_log/index', '1', '短信日志', '0');
INSERT INTO `z_rule` VALUES ('28', 'sms_log/look', '27', '发送结果', '0');
INSERT INTO `z_rule` VALUES ('29', 'config/weixin', '24', '微信配置', '0');
INSERT INTO `z_rule` VALUES ('35', 'wxqrcode/index', '24', '微信场景', '0');
INSERT INTO `z_rule` VALUES ('36', 'wxqrcode/add', '35', '场景添加', '0');
INSERT INTO `z_rule` VALUES ('37', 'wxqrcode/delete', '35', '场景删除', '0');
INSERT INTO `z_rule` VALUES ('38', 'wxmenu/index', '24', '微信菜单管理', '0');

-- ----------------------------
-- Table structure for z_sms_log
-- ----------------------------
DROP TABLE IF EXISTS `z_sms_log`;
CREATE TABLE `z_sms_log` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `mobile` varchar(11) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '发送的手机号',
  `ip` int(11) unsigned NOT NULL COMMENT '发送的ip',
  `msg` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '发送的内容',
  `res` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '发送结果',
  `created_at` int(11) unsigned NOT NULL COMMENT '发送时间',
  `stat` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '短信发送 状态码',
  PRIMARY KEY (`id`),
  KEY `mobile` (`mobile`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='短信日志';

-- ----------------------------
-- Records of z_sms_log
-- ----------------------------
INSERT INTO `z_sms_log` VALUES ('1', '13888888888', '1901417065', '827830', 'O:8:\"stdClass\":2:{s:7:\"Message\";s:2:\"OK\";s:4:\"Code\";s:2:\"OK\";}', '1533883061', 'OK');
INSERT INTO `z_sms_log` VALUES ('2', '13888888888', '2130706433', '261377', 'O:8:\"stdClass\":2:{s:7:\"Message\";s:2:\"OK\";s:4:\"Code\";s:2:\"OK\";}', '1533883083', 'OK');
INSERT INTO `z_sms_log` VALUES ('3', '13888888888', '1901417065', '879256', 'O:8:\"stdClass\":2:{s:7:\"Message\";s:2:\"OK\";s:4:\"Code\";s:2:\"OK\";}', '1533883084', 'OK');
INSERT INTO `z_sms_log` VALUES ('4', '13888888888', '2130706433', '233522', 'O:8:\"stdClass\":2:{s:7:\"Message\";s:2:\"OK\";s:4:\"Code\";s:2:\"OK\";}', '1533803084', 'OK');
INSERT INTO `z_sms_log` VALUES ('5', '13888888888', '2130706433', '854285', 'O:8:\"stdClass\":2:{s:7:\"Message\";s:2:\"OK\";s:4:\"Code\";s:2:\"OK\";}', '1533883085', 'OK');
INSERT INTO `z_sms_log` VALUES ('6', '13888888888', '2130706433', '809908', 'O:8:\"stdClass\":3:{s:7:\"Message\";s:30:\"触发分钟级流控Permits:1\";s:9:\"RequestId\";s:36:\"42949C66-C608-4AAC-84B4-CF83CD144CFD\";s:4:\"Code\";s:26:\"isv.BUSINESS_LIMIT_CONTROL\";}', '1533894106', 'isv.BUSINESS_LIMIT_CONTROL');
INSERT INTO `z_sms_log` VALUES ('7', '13888888888', '2130706433', '702633', 'O:8:\"stdClass\":4:{s:7:\"Message\";s:2:\"OK\";s:9:\"RequestId\";s:36:\"AF0BE351-C978-4D36-96A5-8623DC060787\";s:5:\"BizId\";s:20:\"593306733894312578^0\";s:4:\"Code\";s:2:\"OK\";}', '1533894131', 'OK');

-- ----------------------------
-- Table structure for z_wx_menu
-- ----------------------------
DROP TABLE IF EXISTS `z_wx_menu`;
CREATE TABLE `z_wx_menu` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `index` int(11) unsigned NOT NULL,
  `pindex` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '父id',
  `type` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '菜单类型 null主菜单 link链接 keys关键字',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '菜单名称',
  `content` text COLLATE utf8mb4_unicode_ci COMMENT '文字内容',
  `sort` tinyint(3) NOT NULL COMMENT '排序',
  `created_at` int(11) unsigned NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='微信菜单配置';

-- ----------------------------
-- Records of z_wx_menu
-- ----------------------------
INSERT INTO `z_wx_menu` VALUES ('24', '1', '0', 'view', '商城', '@wx', '0', '1535563669');
INSERT INTO `z_wx_menu` VALUES ('25', '2', '0', 'view', '一级菜单', 'http://www.baidu.com/', '1', '1535563669');
INSERT INTO `z_wx_menu` VALUES ('26', '21', '2', 'view', '导航', 'http://abc.com', '0', '1535563669');
INSERT INTO `z_wx_menu` VALUES ('27', '22', '2', 'view', '二级菜单', 'http://www.baidu.com/', '1', '1535563669');

-- ----------------------------
-- Table structure for z_wx_qrcode
-- ----------------------------
DROP TABLE IF EXISTS `z_wx_qrcode`;
CREATE TABLE `z_wx_qrcode` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `scene_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '场景名',
  `scene_str` char(32) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '场景值ID（字符串形式的ID）',
  `scene_type` tinyint(1) NOT NULL COMMENT '二维码类型 0永久二维码 1临时二维码',
  `expire_seconds` mediumint(8) NOT NULL COMMENT '过期时间',
  `ticket` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '获取的二维码ticket',
  `url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '二维码图片解析后的地址',
  `qrcode_img` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '保存的图片',
  `created_at` int(11) unsigned NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='微信场景二维码';

-- ----------------------------
-- Records of z_wx_qrcode
-- ----------------------------

-- ----------------------------
-- Table structure for z_wx_qrcode_stat
-- ----------------------------
DROP TABLE IF EXISTS `z_wx_qrcode_stat`;
CREATE TABLE `z_wx_qrcode_stat` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `openid` varchar(28) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '用户的openid',
  `stat_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '类型 0 扫描关注  1 关注后扫描',
  `qr_id` int(11) unsigned NOT NULL COMMENT '场景ID',
  `created_at` int(11) unsigned NOT NULL COMMENT '关注时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='微信场景二维码关注';

-- ----------------------------
-- Records of z_wx_qrcode_stat
-- ----------------------------
