<?php
/**
*+------------------
* Tpflow 用户信息
*+------------------
* Copyright (c) 2006~2018 http://cojz8.cn All rights reserved.
*+------------------
* Author: guoguo(1838188896@qq.com)
*+------------------ 
*/
namespace tpflow\db;

use think\facade\Db;

class UserDb{
	public static function config($type='user'){
		$config = require ( BEASE_URL . '/config/common.php');// 
		return $config[$type];
	} 
	/**
	 * 获取用户列表
	 *
	 */
	public static function GetUser() 
	{
		$config = self::config();
		return  Db::name($config['db'])->field($config['field'])->select();
	}
	/**
	 * 获取角色列表
	 *
	 */
	public static function GetRole() 
	{
		$config = self::config('role');
		return  Db::name($config['db'])->field($config['field'])->select();
	}
	/**
	 * 获取AJAX信息
	 *
	 */
	public static function AjaxGet($type,$keyword){
		
		if($type=='user'){
			$config = self::config();
				$map[] = [$config['searchwhere'],'like','%'.$keyword.'%'];
				return Db::name($config['db'])->where($map)->field($config['field'])->select();
		}else{
			$config = self::config('role');
			$map[] = [$config['searchwhere'],'like','%'.$keyword.'%'];
			return Db::name($config['db'])->where($map)->field($config['field'])->select();
		 }
	}
	/**
	 * 查询用户消息
	 *
	 */
	public static function GetUserInfo($id) 
	{
		$config = self::config();
		return  Db::name($config['db'])->where($config['key'],$id)->field($config['field'])->find();
	}
	/**
	 * 查询用户名称
	 *
	 */
	public static function GetUserName($uid) 
	{
		$config = self::config();
		return  Db::name($config['db'])->where($config['key'],$uid)->value($config['getfield']);
	}
	
}