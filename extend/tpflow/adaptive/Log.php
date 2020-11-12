<?php
/**
 *+------------------
 * Tpflow 统一标准接口------代理模式数据库操作统一接口
 *+------------------
 * Copyright (c) 2006~2018 http://cojz8.cn All rights reserved.
 *+------------------
 * Author: guoguo(1838188896@qq.com)
 *+------------------
 */
namespace tpflow\adaptive;

use tpflow\lib\unit;

Class Log{
    
	protected $mode ; 
    public function  __construct(){
		if(unit::gconfig('wf_db_mode')==1){
			$className = '\\tpflow\\custom\\think\\AdapteeLog';
		}else{
			$className = unit::gconfig('wf_db_namespace').'AdapteeLog';
		}
		$this->mode = new $className();
    }
	/**
	 * 工作流审批日志记录
	 *
	 * @param  $uid 实例id
	 * @param  $run_id 运行的工作流id
	 * @param  $content 审批意见
	 * @param  $from_id 单据id
	 * @param  $from_table 单据表
	 * @param  $btn 操作按钮 ok 提交 back 回退 sing 会签  Send 发起 
	 **/
	static function AddrunLog($uid,$run_id,$config,$btn)
	{
		return (new Log())->mode->AddrunLog($uid,$run_id,$config,$btn);
	}
}