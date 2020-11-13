<?php
namespace tpflow\custom\think;
/**
*+------------------
* Tpflow 工作流日志消息
*+------------------
* Copyright (c) 2006~2018 http://cojz8.cn All rights reserved.
*+------------------
* Author: guoguo(1838188896@qq.com)
*+------------------
*/
use think\facade\Db;

class AdapteeLog{
	
	/**
	 * 工作流审批日志记录
	 *
	 * @param  $run_log_data 插入数据
	 **/
	function AddrunLog($run_log_data)
	{
		 $ret = Db::name('run_log')->insertGetId($run_log_data);
		 if(!$ret){
				return  false;
		 }
		return $ret;
	}
	
	
}