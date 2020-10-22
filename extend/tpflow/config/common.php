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
	'database'=>'tpflow4.0',//数据库名称
	'prefix'=>'wf_',//数据库前缀
	'int_url'=>'index',//使用工作流的模块名称
	'user_id' =>'uid',//用户的session名称 
	'role_id' =>'role',//用户角色的session名称 
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
];