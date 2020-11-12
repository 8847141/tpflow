<?php
/**
*+------------------
* Tpflow 配置文件夹
*+------------------
* Copyright (c) 2006~2018 http://cojz8.cn All rights reserved.
*+------------------
* Author: guoguo(1838188896@qq.com)
*+------------------ 
*/
namespace tpflow\config;
return [
	'version'=>'4.0',//当前版本
	'database'=>'tpflow4.0',//数据库名称
	'prefix'=>'wf_',//数据库前缀
	'int_url'=>'/index',//使用工作流的模块名称
	'user_id' =>'uid',//用户的session名称 
	'role_id' =>'role',//用户角色的session名称 
	'work_table'=>'[work]',//特定的表前缀，用于接入工作流的实体表
	/*用户信息配置*/
	'user' => [
		'db'=>'user', //表名
		'key'=>'id', //主键
		'getfield'=>'username',//获取用户名称
		'field'=>'id as id,username as username',//查询筛选字段 用于设计器的选人
		'searchwhere'=>'username'//查询筛选字段 用于设计器where匹配
	],
	/*角色信息配置*/
	'role' => [
		'db'=>'role', //表名
		'key'=>'id', //主键
		'getfield'=>'name',//获取用户名称
		'field'=>'id as id,name as username',//查询筛选字段 用于设计器的选人
		'searchwhere'=>'name'//查询筛选字段 用于设计器where匹配
	],
	/*工作流类别信息配置*/
	'wf_type_mode'=>0,//工作流类别模式 0为数据库驱动，1自定义模式
	'wf_type_data' => [
		['name'=>'news','title'=>'新闻'], //业务表=>业务名称
	],
	'view_return'=>1,//1、直接从lib类库中返回 2、直接返回JSON数据，需要自行进行数据处理
	'wf_bill_mode'=>1,//工作流读取单据信息，系统自带模式,2、自定义模式
	'wf_bill_namespace'=>'',
	'wf_db_mode'=>1,//工作ORM驱动，系统自带模式Think-ORM,2、自定义ORM
	'wf_db_namespace'=>'',
];

