/*
Navicat MySQL Data Transfer

Source Server         : localhost_3306
Source Server Version : 50562
Source Host           : localhost:3306
Source Database       : tpflow4.0

Target Server Type    : MYSQL
Target Server Version : 50562
File Encoding         : 65001

Date: 2020-11-11 15:51:03
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `wf_entrust`
-- ----------------------------
DROP TABLE IF EXISTS `wf_entrust`;
CREATE TABLE `wf_entrust` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `flow_id` int(11) NOT NULL COMMENT '运行id',
  `flow_process` int(11) NOT NULL COMMENT '运行步骤id',
  `entrust_title` varchar(255) DEFAULT NULL COMMENT '标题',
  `entrust_user` varchar(255) NOT NULL COMMENT '被授权人',
  `entrust_name` varchar(255) NOT NULL COMMENT '被授权人名称',
  `entrust_stime` int(11) NOT NULL COMMENT '授权开始时间',
  `entrust_etime` int(11) NOT NULL COMMENT '授权结束时间',
  `entrust_con` longtext COMMENT '授权备注',
  `add_time` int(11) DEFAULT NULL COMMENT '添加时间',
  `old_user` varchar(255) NOT NULL COMMENT '授权人',
  `old_name` varchar(255) NOT NULL COMMENT '授权人名称',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='委托授权表';

-- ----------------------------
-- Records of wf_entrust
-- ----------------------------
INSERT INTO `wf_entrust` VALUES ('1', '0', '0', '副总委托', '7', '董事长', '1577808000', '1604160000', '副总委托给董事长', '1603876151', '5', '副总');

-- ----------------------------
-- Table structure for `wf_entrust_rel`
-- ----------------------------
DROP TABLE IF EXISTS `wf_entrust_rel`;
CREATE TABLE `wf_entrust_rel` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `entrust_id` int(11) NOT NULL COMMENT '授权id',
  `process_id` int(11) NOT NULL COMMENT '步骤id',
  `status` int(11) NOT NULL DEFAULT '0' COMMENT '状态0为新增，2为办结',
  `add_time` datetime DEFAULT NULL COMMENT '添加日期',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='流程授权关系表';

-- ----------------------------
-- Records of wf_entrust_rel
-- ----------------------------
INSERT INTO `wf_entrust_rel` VALUES ('2', '1', '20', '0', '2020-10-28 17:10:03');

-- ----------------------------
-- Table structure for `wf_flow`
-- ----------------------------
DROP TABLE IF EXISTS `wf_flow`;
CREATE TABLE `wf_flow` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(255) DEFAULT NULL COMMENT '流程类别',
  `flow_name` varchar(255) NOT NULL DEFAULT '' COMMENT '流程名称',
  `flow_desc` varchar(255) NOT NULL DEFAULT '' COMMENT '描述',
  `sort_order` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '0不可用1正常',
  `is_del` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `uid` int(11) DEFAULT NULL COMMENT '添加用户',
  `add_time` int(11) DEFAULT NULL COMMENT '添加时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COMMENT='*工作流表';

-- ----------------------------
-- Records of wf_flow
-- ----------------------------
INSERT INTO `wf_flow` VALUES ('1', 'news', '测试工作流', '2', '1', '0', '0', '1', '1601987835');
INSERT INTO `wf_flow` VALUES ('2', 'news', '模板测试', '233', '2', '0', '0', '1', '1602298141');
INSERT INTO `wf_flow` VALUES ('3', 'news', '22333', '22', '22', '1', '0', '1', '1602837774');
INSERT INTO `wf_flow` VALUES ('4', 'news', '22', '33', '33', '1', '0', null, '1603421297');
INSERT INTO `wf_flow` VALUES ('5', 'news', '测试代理模式', '测试代理模式', '0', '0', '0', '1', '1603875576');

-- ----------------------------
-- Table structure for `wf_flow_process`
-- ----------------------------
DROP TABLE IF EXISTS `wf_flow_process`;
CREATE TABLE `wf_flow_process` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `flow_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '流程ID',
  `process_name` varchar(255) NOT NULL DEFAULT '步骤' COMMENT '步骤名称',
  `process_type` char(10) NOT NULL DEFAULT '' COMMENT '步骤类型',
  `process_to` varchar(255) NOT NULL DEFAULT '' COMMENT '转交下一步骤号',
  `auto_person` tinyint(1) unsigned NOT NULL DEFAULT '4' COMMENT '3自由选择|4指定人员|5指定角色|6事务接受',
  `auto_sponsor_ids` varchar(255) NOT NULL DEFAULT '' COMMENT '4指定步骤主办人ids',
  `auto_sponsor_text` varchar(255) NOT NULL DEFAULT '' COMMENT '4指定步骤主办人text',
  `work_ids` varchar(255) NOT NULL DEFAULT '' COMMENT '6事务接受',
  `work_text` varchar(255) NOT NULL DEFAULT '' COMMENT '6事务接受',
  `auto_role_ids` varchar(255) NOT NULL DEFAULT '' COMMENT '5角色ids',
  `auto_role_text` varchar(255) NOT NULL DEFAULT '' COMMENT '5角色 text',
  `range_user_ids` text COMMENT '3自由选择IDS',
  `range_user_text` text COMMENT '3自由选择用户ID',
  `is_sing` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '1允许|2不允许',
  `is_back` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '1允许|2不允许',
  `out_condition` text COMMENT '转出条件',
  `setleft` smallint(5) unsigned NOT NULL DEFAULT '100' COMMENT '左 坐标',
  `settop` smallint(5) unsigned NOT NULL DEFAULT '100' COMMENT '上 坐标',
  `style` text COMMENT '样式 序列化',
  `is_del` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `updatetime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `dateline` int(10) unsigned NOT NULL DEFAULT '0',
  `wf_mode` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '0 单一线性，1，转出条件 2，同步模式',
  `wf_action` varchar(255) NOT NULL DEFAULT 'view' COMMENT '对应方法',
  `work_sql` longtext,
  `work_msg` longtext,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of wf_flow_process
-- ----------------------------
INSERT INTO `wf_flow_process` VALUES ('1', '1', '步骤', 'is_one', '2', '4', '1', '员工', '1', '', '', '', '', '', '1', '1', '[]', '100', '100', '{\"width\":\"120\",\"height\":\"auto\",\"color\":\"#0e76a8\"}', '0', '1602295641', '0', '0', 'view', '', '');
INSERT INTO `wf_flow_process` VALUES ('2', '1', '步骤', 'is_step', '', '3', '', '', '1', '', '', '', '3,1', '主管,员工', '1', '1', '[]', '321', '139', '{\"width\":\"120\",\"height\":\"auto\",\"color\":\"#0e76a8\"}', '0', '1602295641', '0', '0', 'edit', '', '');
INSERT INTO `wf_flow_process` VALUES ('9', '2', '步骤', 'is_one', '10,11', '4', '1', '员工', '1', '', '', '', '', '', '1', '1', '{\"10\":{\"condition\":[\"id= \'6\'\"]},\"11\":{\"condition\":[\"id= \'7\'\"]}}', '100', '100', '{\"width\":\"120\",\"height\":\"auto\",\"color\":\"#0e76a8\"}', '0', '1603790622', '0', '1', 'view', '', '');
INSERT INTO `wf_flow_process` VALUES ('10', '2', '步骤', 'is_step', '', '5', '', '', '1', '', '2', '经理部', '', '', '1', '1', '[]', '689', '60', '{\"width\":\"120\",\"height\":\"auto\",\"color\":\"#0e76a8\"}', '0', '1603790622', '0', '0', 'view', '', '');
INSERT INTO `wf_flow_process` VALUES ('11', '2', '步骤', 'is_step', '12', '3', '', '', '1', '', '', '', '4,3', '主任,主管', '1', '1', '[]', '487', '334', '{\"width\":\"120\",\"height\":\"auto\",\"color\":\"#0e76a8\"}', '0', '1603790622', '0', '0', 'view', '', '');
INSERT INTO `wf_flow_process` VALUES ('12', '2', '步骤', 'is_step', '', '6', '', '', '1', 'uid', '', '', '', '', '1', '1', '[]', '343', '455', '{\"width\":\"120\",\"height\":\"auto\",\"color\":\"#0e76a8\"}', '0', '1603790622', '0', '0', 'view', '', '');
INSERT INTO `wf_flow_process` VALUES ('13', '3', '步骤', 'is_one', '', '4', '', '', '', '', '', '', null, null, '1', '1', null, '100', '100', '{\"width\":\"120\",\"height\":\"auto\",\"color\":\"#0e76a8\"}', '0', '0', '0', '0', 'view', null, null);
INSERT INTO `wf_flow_process` VALUES ('14', '4', '步骤', 'is_one', '', '4', '', '', '', '', '', '', null, null, '1', '1', null, '100', '100', '{\"width\":\"120\",\"height\":\"auto\",\"color\":\"#0e76a8\"}', '0', '0', '0', '0', 'view', null, null);
INSERT INTO `wf_flow_process` VALUES ('15', '5', '步骤', 'is_one', '16', '4', '1', '员工', '1', '', '', '', '', '', '1', '1', '[]', '100', '100', '{\"width\":\"120\",\"height\":\"auto\",\"color\":\"#0e76a8\"}', '0', '1603875592', '0', '0', 'view', '', '');
INSERT INTO `wf_flow_process` VALUES ('16', '5', '步骤', 'is_step', '17', '4', '2', '经理', '1', '', '', '', '', '', '1', '1', '[]', '257', '179', '{\"width\":\"120\",\"height\":\"auto\",\"color\":\"#0e76a8\"}', '0', '1603875592', '0', '0', 'view', '', '');
INSERT INTO `wf_flow_process` VALUES ('17', '5', '步骤', 'is_step', '', '4', '5', '副总', '1', '', '', '', '', '', '1', '1', '[]', '565', '267', '{\"width\":\"120\",\"height\":\"auto\",\"color\":\"#0e76a8\"}', '0', '1603875592', '0', '0', 'view', '', '');

-- ----------------------------
-- Table structure for `wf_news`
-- ----------------------------
DROP TABLE IF EXISTS `wf_news`;
CREATE TABLE `wf_news` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '编号',
  `uid` int(11) NOT NULL COMMENT '用户id',
  `add_time` int(11) DEFAULT NULL COMMENT '新增时间',
  `new_title` varchar(255) DEFAULT NULL COMMENT '新闻标题',
  `new_type` int(11) DEFAULT NULL COMMENT '新闻类别',
  `new_top` int(11) NOT NULL DEFAULT '0' COMMENT '是否置顶',
  `new_con` longtext COMMENT '新闻内容',
  `new_user` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '0' COMMENT '-1回退修改0 保存中1流程中 2通过',
  `uptime` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 COMMENT='[work]新闻表';

-- ----------------------------
-- Records of wf_news
-- ----------------------------
INSERT INTO `wf_news` VALUES ('11', '1', '1603960688', '22', '1', '1', '2233323322', null, '1', '1604025764');
INSERT INTO `wf_news` VALUES ('12', '7', '1604026456', '33', '1', '1', '33', null, '1', '1604026462');
INSERT INTO `wf_news` VALUES ('13', '1', '1604114219', '33', '1', '1', '333', null, '1', '1604114229');
INSERT INTO `wf_news` VALUES ('14', '2', '1604308116', '22', '1', '1', '22', null, '1', '1604308376');

-- ----------------------------
-- Table structure for `wf_news_type`
-- ----------------------------
DROP TABLE IF EXISTS `wf_news_type`;
CREATE TABLE `wf_news_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(255) DEFAULT NULL COMMENT '新闻类别',
  `uid` int(11) DEFAULT NULL,
  `add_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='新闻类别';

-- ----------------------------
-- Records of wf_news_type
-- ----------------------------
INSERT INTO `wf_news_type` VALUES ('1', '新闻', null, null);
INSERT INTO `wf_news_type` VALUES ('2', '公告', null, null);

-- ----------------------------
-- Table structure for `wf_role`
-- ----------------------------
DROP TABLE IF EXISTS `wf_role`;
CREATE TABLE `wf_role` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL COMMENT '后台组名',
  `pid` smallint(6) unsigned NOT NULL DEFAULT '0' COMMENT '父ID',
  `status` tinyint(1) unsigned DEFAULT '0' COMMENT '是否激活 1：是 0：否',
  `sort` smallint(6) unsigned NOT NULL DEFAULT '0' COMMENT '排序权重',
  `remark` varchar(255) DEFAULT NULL COMMENT '备注说明',
  PRIMARY KEY (`id`),
  KEY `pid` (`pid`),
  KEY `status` (`status`)
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=utf8 COMMENT='模拟用户角色表';

-- ----------------------------
-- Records of wf_role
-- ----------------------------
INSERT INTO `wf_role` VALUES ('1', '员工部', '0', '1', '0', '');
INSERT INTO `wf_role` VALUES ('2', '经理部', '0', '1', '0', '');
INSERT INTO `wf_role` VALUES ('3', '主管部', '0', '1', '0', '');
INSERT INTO `wf_role` VALUES ('4', '主任部', '0', '1', '0', '');
INSERT INTO `wf_role` VALUES ('5', '副总', '0', '1', '0', '');
INSERT INTO `wf_role` VALUES ('6', '总经理', '0', '1', '0', '');
INSERT INTO `wf_role` VALUES ('7', '董事长', '0', '1', '0', '');

-- ----------------------------
-- Table structure for `wf_role_user`
-- ----------------------------
DROP TABLE IF EXISTS `wf_role_user`;
CREATE TABLE `wf_role_user` (
  `user_id` int(10) unsigned NOT NULL,
  `role_id` smallint(6) unsigned NOT NULL,
  KEY `group_id` (`role_id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of wf_role_user
-- ----------------------------
INSERT INTO `wf_role_user` VALUES ('1', '1');
INSERT INTO `wf_role_user` VALUES ('2', '2');
INSERT INTO `wf_role_user` VALUES ('3', '3');
INSERT INTO `wf_role_user` VALUES ('4', '4');
INSERT INTO `wf_role_user` VALUES ('5', '5');
INSERT INTO `wf_role_user` VALUES ('6', '6');
INSERT INTO `wf_role_user` VALUES ('7', '7');

-- ----------------------------
-- Table structure for `wf_run`
-- ----------------------------
DROP TABLE IF EXISTS `wf_run`;
CREATE TABLE `wf_run` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Pid',
  `from_table` varchar(255) DEFAULT NULL COMMENT '单据表，不带前缀',
  `from_id` int(11) DEFAULT NULL,
  `pid_flow_step` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT 'Pid',
  `cache_run_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '多个子流程时pid无法识别cache所以加这个字段pid>0',
  `uid` int(10) unsigned NOT NULL DEFAULT '0',
  `flow_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '流程id 正常流程',
  `cat_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '流程分类ID',
  `run_name` varchar(255) DEFAULT '' COMMENT '名称',
  `run_flow_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '流转到什么ID',
  `run_flow_process` varchar(255) DEFAULT NULL COMMENT '流转到第几步',
  `att_ids` varchar(255) NOT NULL DEFAULT '' COMMENT '附件ids',
  `endtime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '结束时间',
  `status` int(1) unsigned NOT NULL DEFAULT '0' COMMENT '状态，0流程中，1回退,2通过',
  `is_del` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `updatetime` int(10) unsigned NOT NULL DEFAULT '0',
  `dateline` int(10) unsigned NOT NULL DEFAULT '0',
  `is_sing` int(11) NOT NULL DEFAULT '0',
  `sing_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pid` (`pid`),
  KEY `pid_flow_step` (`pid_flow_step`),
  KEY `cache_run_id` (`cache_run_id`),
  KEY `uid` (`uid`),
  KEY `is_del` (`is_del`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of wf_run
-- ----------------------------
INSERT INTO `wf_run` VALUES ('1', '0', 'news', '11', '0', '0', '1', '5', '0', '11', '5', '15', '', '1604023828', '1', '0', '0', '1603961987', '0', null);
INSERT INTO `wf_run` VALUES ('2', '0', 'news', '11', '0', '0', '1', '5', '0', '11', '5', '15', '', '1604023953', '1', '0', '0', '1604023938', '0', null);
INSERT INTO `wf_run` VALUES ('3', '0', 'news', '11', '0', '0', '1', '5', '0', '11', '5', '15', '', '1604024006', '1', '0', '0', '1604023998', '0', null);
INSERT INTO `wf_run` VALUES ('4', '0', 'news', '11', '0', '0', '1', '5', '0', '11', '5', '15', '', '1604024069', '1', '0', '0', '1604024062', '0', null);
INSERT INTO `wf_run` VALUES ('5', '0', 'news', '11', '0', '0', '1', '5', '0', '11', '5', '15', '', '1604024415', '1', '0', '0', '1604024401', '0', null);
INSERT INTO `wf_run` VALUES ('6', '0', 'news', '11', '0', '0', '1', '5', '0', '11', '5', '16', '', '1604027299', '0', '0', '0', '1604025764', '0', '2');
INSERT INTO `wf_run` VALUES ('7', '0', 'news', '12', '0', '0', '7', '5', '0', '12', '5', '16', '', '0', '0', '0', '0', '1604026462', '0', null);
INSERT INTO `wf_run` VALUES ('8', '0', 'news', '13', '0', '0', '1', '5', '0', '13', '5', '16', '', '0', '0', '0', '0', '1604114229', '0', null);
INSERT INTO `wf_run` VALUES ('9', '0', 'news', '14', '0', '0', '2', '1', '0', '14', '1', '1', '', '0', '0', '0', '0', '1604308376', '0', null);

-- ----------------------------
-- Table structure for `wf_run_cache`
-- ----------------------------
DROP TABLE IF EXISTS `wf_run_cache`;
CREATE TABLE `wf_run_cache` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `run_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT ' 缓存run步骤等信息',
  `form_id` int(10) unsigned NOT NULL DEFAULT '0',
  `flow_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '流程ID',
  `run_form` text COMMENT '模板信息',
  `run_flow` text COMMENT '流程信息',
  `run_flow_process` text COMMENT '流程步骤信息 ',
  `is_del` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `updatetime` int(10) unsigned NOT NULL DEFAULT '0',
  `dateline` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `run_id` (`run_id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of wf_run_cache
-- ----------------------------
INSERT INTO `wf_run_cache` VALUES ('1', '1', '11', '5', '', '{\"id\":5,\"type\":\"news\",\"flow_name\":\"\\u6d4b\\u8bd5\\u4ee3\\u7406\\u6a21\\u5f0f\",\"flow_desc\":\"\\u6d4b\\u8bd5\\u4ee3\\u7406\\u6a21\\u5f0f\",\"sort_order\":0,\"status\":0,\"is_del\":0,\"uid\":1,\"add_time\":1603875576}', '{\"id\":15,\"flow_id\":5,\"process_name\":\"\\u6b65\\u9aa4\",\"process_type\":\"is_one\",\"process_to\":\"16\",\"auto_person\":4,\"auto_sponsor_ids\":\"1\",\"auto_sponsor_text\":\"\\u5458\\u5de5\",\"work_ids\":\"1\",\"work_text\":\"\",\"auto_role_ids\":\"\",\"auto_role_text\":\"\",\"range_user_ids\":\"\",\"range_user_text\":\"\",\"is_sing\":1,\"is_back\":1,\"out_condition\":\"[]\",\"setleft\":100,\"settop\":100,\"style\":\"{\\\"width\\\":\\\"120\\\",\\\"height\\\":\\\"auto\\\",\\\"color\\\":\\\"#0e76a8\\\"}\",\"is_del\":0,\"updatetime\":1603875592,\"dateline\":0,\"wf_mode\":0,\"wf_action\":\"view\",\"work_sql\":\"\",\"work_msg\":\"\"}', '0', '0', '1603961987');
INSERT INTO `wf_run_cache` VALUES ('2', '2', '11', '5', '', '{\"id\":5,\"type\":\"news\",\"flow_name\":\"\\u6d4b\\u8bd5\\u4ee3\\u7406\\u6a21\\u5f0f\",\"flow_desc\":\"\\u6d4b\\u8bd5\\u4ee3\\u7406\\u6a21\\u5f0f\",\"sort_order\":0,\"status\":0,\"is_del\":0,\"uid\":1,\"add_time\":1603875576}', '{\"id\":15,\"flow_id\":5,\"process_name\":\"\\u6b65\\u9aa4\",\"process_type\":\"is_one\",\"process_to\":\"16\",\"auto_person\":4,\"auto_sponsor_ids\":\"1\",\"auto_sponsor_text\":\"\\u5458\\u5de5\",\"work_ids\":\"1\",\"work_text\":\"\",\"auto_role_ids\":\"\",\"auto_role_text\":\"\",\"range_user_ids\":\"\",\"range_user_text\":\"\",\"is_sing\":1,\"is_back\":1,\"out_condition\":\"[]\",\"setleft\":100,\"settop\":100,\"style\":\"{\\\"width\\\":\\\"120\\\",\\\"height\\\":\\\"auto\\\",\\\"color\\\":\\\"#0e76a8\\\"}\",\"is_del\":0,\"updatetime\":1603875592,\"dateline\":0,\"wf_mode\":0,\"wf_action\":\"view\",\"work_sql\":\"\",\"work_msg\":\"\"}', '0', '0', '1604023938');
INSERT INTO `wf_run_cache` VALUES ('3', '3', '11', '5', '', '{\"id\":5,\"type\":\"news\",\"flow_name\":\"\\u6d4b\\u8bd5\\u4ee3\\u7406\\u6a21\\u5f0f\",\"flow_desc\":\"\\u6d4b\\u8bd5\\u4ee3\\u7406\\u6a21\\u5f0f\",\"sort_order\":0,\"status\":0,\"is_del\":0,\"uid\":1,\"add_time\":1603875576}', '{\"id\":15,\"flow_id\":5,\"process_name\":\"\\u6b65\\u9aa4\",\"process_type\":\"is_one\",\"process_to\":\"16\",\"auto_person\":4,\"auto_sponsor_ids\":\"1\",\"auto_sponsor_text\":\"\\u5458\\u5de5\",\"work_ids\":\"1\",\"work_text\":\"\",\"auto_role_ids\":\"\",\"auto_role_text\":\"\",\"range_user_ids\":\"\",\"range_user_text\":\"\",\"is_sing\":1,\"is_back\":1,\"out_condition\":\"[]\",\"setleft\":100,\"settop\":100,\"style\":\"{\\\"width\\\":\\\"120\\\",\\\"height\\\":\\\"auto\\\",\\\"color\\\":\\\"#0e76a8\\\"}\",\"is_del\":0,\"updatetime\":1603875592,\"dateline\":0,\"wf_mode\":0,\"wf_action\":\"view\",\"work_sql\":\"\",\"work_msg\":\"\"}', '0', '0', '1604023998');
INSERT INTO `wf_run_cache` VALUES ('4', '4', '11', '5', '', '{\"id\":5,\"type\":\"news\",\"flow_name\":\"\\u6d4b\\u8bd5\\u4ee3\\u7406\\u6a21\\u5f0f\",\"flow_desc\":\"\\u6d4b\\u8bd5\\u4ee3\\u7406\\u6a21\\u5f0f\",\"sort_order\":0,\"status\":0,\"is_del\":0,\"uid\":1,\"add_time\":1603875576}', '{\"id\":15,\"flow_id\":5,\"process_name\":\"\\u6b65\\u9aa4\",\"process_type\":\"is_one\",\"process_to\":\"16\",\"auto_person\":4,\"auto_sponsor_ids\":\"1\",\"auto_sponsor_text\":\"\\u5458\\u5de5\",\"work_ids\":\"1\",\"work_text\":\"\",\"auto_role_ids\":\"\",\"auto_role_text\":\"\",\"range_user_ids\":\"\",\"range_user_text\":\"\",\"is_sing\":1,\"is_back\":1,\"out_condition\":\"[]\",\"setleft\":100,\"settop\":100,\"style\":\"{\\\"width\\\":\\\"120\\\",\\\"height\\\":\\\"auto\\\",\\\"color\\\":\\\"#0e76a8\\\"}\",\"is_del\":0,\"updatetime\":1603875592,\"dateline\":0,\"wf_mode\":0,\"wf_action\":\"view\",\"work_sql\":\"\",\"work_msg\":\"\"}', '0', '0', '1604024062');
INSERT INTO `wf_run_cache` VALUES ('5', '5', '11', '5', '', '{\"id\":5,\"type\":\"news\",\"flow_name\":\"\\u6d4b\\u8bd5\\u4ee3\\u7406\\u6a21\\u5f0f\",\"flow_desc\":\"\\u6d4b\\u8bd5\\u4ee3\\u7406\\u6a21\\u5f0f\",\"sort_order\":0,\"status\":0,\"is_del\":0,\"uid\":1,\"add_time\":1603875576}', '{\"id\":15,\"flow_id\":5,\"process_name\":\"\\u6b65\\u9aa4\",\"process_type\":\"is_one\",\"process_to\":\"16\",\"auto_person\":4,\"auto_sponsor_ids\":\"1\",\"auto_sponsor_text\":\"\\u5458\\u5de5\",\"work_ids\":\"1\",\"work_text\":\"\",\"auto_role_ids\":\"\",\"auto_role_text\":\"\",\"range_user_ids\":\"\",\"range_user_text\":\"\",\"is_sing\":1,\"is_back\":1,\"out_condition\":\"[]\",\"setleft\":100,\"settop\":100,\"style\":\"{\\\"width\\\":\\\"120\\\",\\\"height\\\":\\\"auto\\\",\\\"color\\\":\\\"#0e76a8\\\"}\",\"is_del\":0,\"updatetime\":1603875592,\"dateline\":0,\"wf_mode\":0,\"wf_action\":\"view\",\"work_sql\":\"\",\"work_msg\":\"\"}', '0', '0', '1604024401');
INSERT INTO `wf_run_cache` VALUES ('6', '6', '11', '5', '', '{\"id\":5,\"type\":\"news\",\"flow_name\":\"\\u6d4b\\u8bd5\\u4ee3\\u7406\\u6a21\\u5f0f\",\"flow_desc\":\"\\u6d4b\\u8bd5\\u4ee3\\u7406\\u6a21\\u5f0f\",\"sort_order\":0,\"status\":0,\"is_del\":0,\"uid\":1,\"add_time\":1603875576}', '{\"id\":15,\"flow_id\":5,\"process_name\":\"\\u6b65\\u9aa4\",\"process_type\":\"is_one\",\"process_to\":\"16\",\"auto_person\":4,\"auto_sponsor_ids\":\"1\",\"auto_sponsor_text\":\"\\u5458\\u5de5\",\"work_ids\":\"1\",\"work_text\":\"\",\"auto_role_ids\":\"\",\"auto_role_text\":\"\",\"range_user_ids\":\"\",\"range_user_text\":\"\",\"is_sing\":1,\"is_back\":1,\"out_condition\":\"[]\",\"setleft\":100,\"settop\":100,\"style\":\"{\\\"width\\\":\\\"120\\\",\\\"height\\\":\\\"auto\\\",\\\"color\\\":\\\"#0e76a8\\\"}\",\"is_del\":0,\"updatetime\":1603875592,\"dateline\":0,\"wf_mode\":0,\"wf_action\":\"view\",\"work_sql\":\"\",\"work_msg\":\"\"}', '0', '0', '1604025764');
INSERT INTO `wf_run_cache` VALUES ('7', '7', '12', '5', '', '{\"id\":5,\"type\":\"news\",\"flow_name\":\"\\u6d4b\\u8bd5\\u4ee3\\u7406\\u6a21\\u5f0f\",\"flow_desc\":\"\\u6d4b\\u8bd5\\u4ee3\\u7406\\u6a21\\u5f0f\",\"sort_order\":0,\"status\":0,\"is_del\":0,\"uid\":1,\"add_time\":1603875576}', '{\"id\":15,\"flow_id\":5,\"process_name\":\"\\u6b65\\u9aa4\",\"process_type\":\"is_one\",\"process_to\":\"16\",\"auto_person\":4,\"auto_sponsor_ids\":\"1\",\"auto_sponsor_text\":\"\\u5458\\u5de5\",\"work_ids\":\"1\",\"work_text\":\"\",\"auto_role_ids\":\"\",\"auto_role_text\":\"\",\"range_user_ids\":\"\",\"range_user_text\":\"\",\"is_sing\":1,\"is_back\":1,\"out_condition\":\"[]\",\"setleft\":100,\"settop\":100,\"style\":\"{\\\"width\\\":\\\"120\\\",\\\"height\\\":\\\"auto\\\",\\\"color\\\":\\\"#0e76a8\\\"}\",\"is_del\":0,\"updatetime\":1603875592,\"dateline\":0,\"wf_mode\":0,\"wf_action\":\"view\",\"work_sql\":\"\",\"work_msg\":\"\"}', '0', '0', '1604026462');
INSERT INTO `wf_run_cache` VALUES ('8', '8', '13', '5', '', '{\"id\":5,\"type\":\"news\",\"flow_name\":\"\\u6d4b\\u8bd5\\u4ee3\\u7406\\u6a21\\u5f0f\",\"flow_desc\":\"\\u6d4b\\u8bd5\\u4ee3\\u7406\\u6a21\\u5f0f\",\"sort_order\":0,\"status\":0,\"is_del\":0,\"uid\":1,\"add_time\":1603875576}', '{\"id\":15,\"flow_id\":5,\"process_name\":\"\\u6b65\\u9aa4\",\"process_type\":\"is_one\",\"process_to\":\"16\",\"auto_person\":4,\"auto_sponsor_ids\":\"1\",\"auto_sponsor_text\":\"\\u5458\\u5de5\",\"work_ids\":\"1\",\"work_text\":\"\",\"auto_role_ids\":\"\",\"auto_role_text\":\"\",\"range_user_ids\":\"\",\"range_user_text\":\"\",\"is_sing\":1,\"is_back\":1,\"out_condition\":\"[]\",\"setleft\":100,\"settop\":100,\"style\":\"{\\\"width\\\":\\\"120\\\",\\\"height\\\":\\\"auto\\\",\\\"color\\\":\\\"#0e76a8\\\"}\",\"is_del\":0,\"updatetime\":1603875592,\"dateline\":0,\"wf_mode\":0,\"wf_action\":\"view\",\"work_sql\":\"\",\"work_msg\":\"\"}', '0', '0', '1604114229');
INSERT INTO `wf_run_cache` VALUES ('9', '9', '14', '1', '', '{\"id\":1,\"type\":\"news\",\"flow_name\":\"\\u6d4b\\u8bd5\\u5de5\\u4f5c\\u6d41\",\"flow_desc\":\"2\",\"sort_order\":1,\"status\":0,\"is_del\":0,\"uid\":1,\"add_time\":1601987835}', '{\"id\":1,\"flow_id\":1,\"process_name\":\"\\u6b65\\u9aa4\",\"process_type\":\"is_one\",\"process_to\":\"2\",\"auto_person\":4,\"auto_sponsor_ids\":\"1\",\"auto_sponsor_text\":\"\\u5458\\u5de5\",\"work_ids\":\"1\",\"work_text\":\"\",\"auto_role_ids\":\"\",\"auto_role_text\":\"\",\"range_user_ids\":\"\",\"range_user_text\":\"\",\"is_sing\":1,\"is_back\":1,\"out_condition\":\"[]\",\"setleft\":100,\"settop\":100,\"style\":\"{\\\"width\\\":\\\"120\\\",\\\"height\\\":\\\"auto\\\",\\\"color\\\":\\\"#0e76a8\\\"}\",\"is_del\":0,\"updatetime\":1602295641,\"dateline\":0,\"wf_mode\":0,\"wf_action\":\"view\",\"work_sql\":\"\",\"work_msg\":\"\"}', '0', '0', '1604308376');

-- ----------------------------
-- Table structure for `wf_run_log`
-- ----------------------------
DROP TABLE IF EXISTS `wf_run_log`;
CREATE TABLE `wf_run_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `from_id` int(11) DEFAULT NULL COMMENT '单据ID',
  `from_table` varchar(255) DEFAULT NULL COMMENT '单据表',
  `run_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '流转id',
  `run_flow` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '流程ID',
  `content` text NOT NULL COMMENT '日志内容',
  `dateline` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `btn` varchar(255) DEFAULT NULL COMMENT '提交操作信息',
  `art` longtext COMMENT '附件日志',
  `work_info` varchar(255) DEFAULT NULL COMMENT '事务日志',
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`),
  KEY `run_id` (`run_id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of wf_run_log
-- ----------------------------
INSERT INTO `wf_run_log` VALUES ('1', '1', '11', 'news', '1', '0', '1', '1603961987', 'Send', '', '');
INSERT INTO `wf_run_log` VALUES ('2', '1', '11', 'news', '1', '0', '[管理员代办]22', '1604023828', 'Back', '', 'work_sql:null|work_msg:null');
INSERT INTO `wf_run_log` VALUES ('3', '1', '11', 'news', '2', '0', '2', '1604023938', 'Send', '', '');
INSERT INTO `wf_run_log` VALUES ('4', '1', '11', 'news', '2', '0', '233', '1604023953', 'Back', '', 'work_sql:null|work_msg:null');
INSERT INTO `wf_run_log` VALUES ('5', '1', '11', 'news', '3', '0', '22', '1604023998', 'Send', '', '');
INSERT INTO `wf_run_log` VALUES ('6', '1', '11', 'news', '3', '0', '333', '1604024006', 'Back', '', 'work_sql:null|work_msg:null');
INSERT INTO `wf_run_log` VALUES ('7', '1', '11', 'news', '4', '0', '2', '1604024062', 'Send', '', '');
INSERT INTO `wf_run_log` VALUES ('8', '1', '11', 'news', '4', '0', '33', '1604024069', 'Back', '', 'work_sql:null|work_msg:null');
INSERT INTO `wf_run_log` VALUES ('9', '1', '11', 'news', '5', '0', '2', '1604024401', 'Send', '', '');
INSERT INTO `wf_run_log` VALUES ('10', '1', '11', 'news', '5', '0', '333', '1604024415', 'Back', '', 'work_sql:null|work_msg:null');
INSERT INTO `wf_run_log` VALUES ('11', '1', '11', 'news', '6', '0', '3', '1604025764', 'Send', '', '');
INSERT INTO `wf_run_log` VALUES ('12', '1', '11', 'news', '6', '0', '222', '1604026422', 'Sing', '', 'work_sql:null|work_msg:null');
INSERT INTO `wf_run_log` VALUES ('13', '7', '12', 'news', '7', '0', '22', '1604026462', 'Send', '', '');
INSERT INTO `wf_run_log` VALUES ('14', '7', '11', 'news', '6', '0', '22', '1604027299', 'SingSing', '', 'work_sql:null|work_msg:null');
INSERT INTO `wf_run_log` VALUES ('15', '6', '11', 'news', '6', '0', '222', '1604027321', 'sok', '', 'work_sql:null|work_msg:null');
INSERT INTO `wf_run_log` VALUES ('16', '1', '13', 'news', '8', '0', '22', '1604114229', 'Send', '', '');
INSERT INTO `wf_run_log` VALUES ('17', '1', '13', 'news', '8', '0', '2222', '1604115175', 'ok', '', 'work_sql:null|work_msg:null');
INSERT INTO `wf_run_log` VALUES ('18', '1', '12', 'news', '7', '0', '333', '1604115180', 'ok', '', 'work_sql:null|work_msg:null');
INSERT INTO `wf_run_log` VALUES ('19', '2', '14', 'news', '9', '0', '2', '1604308376', 'Send', '', '');

-- ----------------------------
-- Table structure for `wf_run_process`
-- ----------------------------
DROP TABLE IF EXISTS `wf_run_process`;
CREATE TABLE `wf_run_process` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(10) unsigned NOT NULL DEFAULT '0',
  `run_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '当前流转id',
  `run_flow` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '属于那个流程的id',
  `run_flow_process` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '当前步骤编号',
  `parent_flow` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '上一步流程',
  `parent_flow_process` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '上一步骤号',
  `run_child` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '开始转入子流程run_id 如果转入子流程，则在这里也记录',
  `remark` text COMMENT '备注',
  `is_receive_type` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否先接收人为主办人',
  `auto_person` tinyint(4) DEFAULT NULL,
  `sponsor_text` varchar(255) DEFAULT NULL,
  `sponsor_ids` varchar(255) DEFAULT NULL,
  `is_sponsor` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否步骤主办人 0否(默认) 1是',
  `is_sing` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否已会签过',
  `is_back` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '被退回的 0否(默认) 1是',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '状态 0为未接收（默认），1为办理中 ,2为已转交,3为已结束4为已打回',
  `js_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '接收时间',
  `bl_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '办理时间',
  `jj_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '转交时间,最后一步等同办结时间',
  `is_del` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `updatetime` int(10) unsigned NOT NULL DEFAULT '0',
  `dateline` int(10) unsigned NOT NULL DEFAULT '0',
  `wf_mode` int(11) DEFAULT NULL,
  `wf_action` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`),
  KEY `run_id` (`run_id`),
  KEY `status` (`status`),
  KEY `is_del` (`is_del`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of wf_run_process
-- ----------------------------
INSERT INTO `wf_run_process` VALUES ('1', '1', '1', '5', '15', '0', '0', '0', '[管理员代办]22', '0', '4', '员工', '1', '0', '1', '1', '2', '1603961987', '1604023828', '0', '0', '0', '1603961987', '0', 'view');
INSERT INTO `wf_run_process` VALUES ('2', '1', '2', '5', '15', '0', '0', '0', '233', '0', '4', '员工', '1', '0', '1', '1', '2', '1604023938', '1604023953', '0', '0', '0', '1604023938', '0', 'view');
INSERT INTO `wf_run_process` VALUES ('3', '1', '3', '5', '15', '0', '0', '0', '333', '0', '4', '员工', '1', '0', '1', '1', '2', '1604023998', '1604024006', '0', '0', '0', '1604023998', '0', 'view');
INSERT INTO `wf_run_process` VALUES ('4', '1', '4', '5', '15', '0', '0', '0', '33', '0', '4', '员工', '1', '0', '1', '1', '2', '1604024062', '1604024069', '0', '0', '0', '1604024062', '0', 'view');
INSERT INTO `wf_run_process` VALUES ('5', '1', '5', '5', '15', '0', '0', '0', '333', '0', '4', '员工', '1', '0', '1', '1', '2', '1604024401', '1604024415', '0', '0', '0', '1604024401', '0', 'view');
INSERT INTO `wf_run_process` VALUES ('6', '1', '6', '5', '15', '0', '0', '0', '222', '0', '4', '员工', '1', '0', '1', '1', '2', '1604025764', '1604026422', '0', '0', '0', '1604025764', '0', 'view');
INSERT INTO `wf_run_process` VALUES ('7', '7', '7', '5', '15', '0', '0', '0', '333', '0', '4', '员工', '1', '0', '1', '1', '2', '1604026462', '1604115180', '0', '0', '0', '1604026462', '0', 'view');
INSERT INTO `wf_run_process` VALUES ('8', '6', '6', '5', '16', '0', '0', '0', '', '0', '4', '经理', '2', '0', '1', '1', '0', '1604027321', '0', '0', '0', '0', '1604027321', '0', 'view');
INSERT INTO `wf_run_process` VALUES ('9', '1', '8', '5', '15', '0', '0', '0', '2222', '0', '4', '员工', '1', '0', '1', '1', '2', '1604114229', '1604115175', '0', '0', '0', '1604114229', '0', 'view');
INSERT INTO `wf_run_process` VALUES ('10', '1', '8', '5', '16', '0', '0', '0', '', '0', '4', '经理', '2', '0', '1', '1', '0', '1604115175', '0', '0', '0', '0', '1604115175', '0', 'view');
INSERT INTO `wf_run_process` VALUES ('11', '1', '7', '5', '16', '0', '0', '0', '', '0', '4', '经理', '2', '0', '1', '1', '0', '1604115180', '0', '0', '0', '0', '1604115180', '0', 'view');
INSERT INTO `wf_run_process` VALUES ('12', '2', '9', '1', '1', '0', '0', '0', '', '0', '4', '员工', '1', '0', '1', '1', '0', '1604308376', '0', '0', '0', '0', '1604308376', '0', 'view');

-- ----------------------------
-- Table structure for `wf_run_sign`
-- ----------------------------
DROP TABLE IF EXISTS `wf_run_sign`;
CREATE TABLE `wf_run_sign` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(10) unsigned NOT NULL DEFAULT '0',
  `run_id` int(10) unsigned NOT NULL DEFAULT '0',
  `run_flow` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '流程ID,子流程时区分run step',
  `run_flow_process` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '当前步骤编号',
  `content` text COMMENT '会签内容',
  `is_agree` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '审核意见：1同意；2不同意',
  `sign_att_id` int(10) unsigned NOT NULL DEFAULT '0',
  `sign_look` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '步骤设置的会签可见性,0总是可见（默认）,1本步骤经办人之间不可见2针对其他步骤不可见',
  `dateline` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`),
  KEY `run_id` (`run_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of wf_run_sign
-- ----------------------------
INSERT INTO `wf_run_sign` VALUES ('1', '7', '6', '5', '6', '22', '1', '0', '0', '1604027298');
INSERT INTO `wf_run_sign` VALUES ('2', '6', '6', '5', '6', '222', '1', '0', '0', '1604027321');

-- ----------------------------
-- Table structure for `wf_user`
-- ----------------------------
DROP TABLE IF EXISTS `wf_user`;
CREATE TABLE `wf_user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` char(32) NOT NULL,
  `tel` varchar(255) DEFAULT NULL,
  `mail` varchar(255) DEFAULT NULL,
  `role` smallint(6) unsigned NOT NULL COMMENT '组ID',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '状态 1:启用 0:禁止',
  `remark` varchar(255) DEFAULT NULL COMMENT '备注说明',
  `last_login_time` int(11) unsigned NOT NULL COMMENT '最后登录时间',
  `last_login_ip` varchar(15) DEFAULT NULL COMMENT '最后登录IP',
  `login_count` int(11) DEFAULT '0',
  `last_location` varchar(100) DEFAULT NULL COMMENT '最后登录位置',
  `add_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `username` (`username`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COMMENT='用户表';

-- ----------------------------
-- Records of wf_user
-- ----------------------------
INSERT INTO `wf_user` VALUES ('1', '员工', 'c4ca4238a0b923820dcc509a6f75849b', '1', '1', '1', '0', '1', '1522372036', '127.0.0.1', '0', '新建用户', '1522372036');
INSERT INTO `wf_user` VALUES ('2', '经理', 'c4ca4238a0b923820dcc509a6f75849b', '1', '1', '2', '0', '1', '1522372556', '127.0.0.1', '0', '新建用户', '1522372556');
INSERT INTO `wf_user` VALUES ('3', '主管', 'c4ca4238a0b923820dcc509a6f75849b', '1', '1', '3', '0', '1', '1522376353', '127.0.0.1', '0', '新建用户', '1522376353');
INSERT INTO `wf_user` VALUES ('4', '主任', 'c4ca4238a0b923820dcc509a6f75849b', '1', '1', '4', '0', '1', '1522376372', '127.0.0.1', '0', '新建用户', '1522376372');
INSERT INTO `wf_user` VALUES ('5', '副总', 'c4ca4238a0b923820dcc509a6f75849b', '1', '1', '5', '0', '1', '1522376385', '127.0.0.1', '0', '新建用户', '1522376385');
INSERT INTO `wf_user` VALUES ('6', '总经理', 'c4ca4238a0b923820dcc509a6f75849b', '1', '1', '6', '0', '1', '1522376401', '127.0.0.1', '0', '新建用户', '1522376401');
INSERT INTO `wf_user` VALUES ('7', '董事长', 'c4ca4238a0b923820dcc509a6f75849b', '1', '1', '7', '0', '1', '1522376413', '127.0.0.1', '0', '新建用户', '1522376413');

-- ----------------------------
-- Table structure for `wf_workinfo`
-- ----------------------------
DROP TABLE IF EXISTS `wf_workinfo`;
CREATE TABLE `wf_workinfo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bill_info` longtext COMMENT '单据JSON',
  `data` longtext COMMENT '处理数据',
  `info` longtext COMMENT '处理结果',
  `datetime` datetime DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL COMMENT '类型',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of wf_workinfo
-- ----------------------------
