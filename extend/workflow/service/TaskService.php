<?php
/**
*+------------------
* Tpflow 工作流任务服务
*+------------------ 
* Copyright (c) 2006~2018 http://cojz8.cn All rights reserved.
*+------------------
* Author: guoguo(1838188896@qq.com)
*+------------------
*/

namespace workflow\service;

use workflow\service\command\TaskFlow;
use workflow\service\command\BackFlow;
use workflow\service\command\SingFlow;
use workflow\service\command\SupFlow;

class TaskService{
	/**
	 * 普通流程通过
	 * 
	 * @param  $config 参数信息
	 * @param  $uid  用户ID
	 */
	public function doTask($config,$uid){
		$command = new TaskFlow();
		return $command->doTask($config,$uid);
	}
	/**
	 * 流程驳回
	 * 
	 * @param  $config 参数信息
	 * @param  $uid  用户ID
	 */
	public function doBack($config,$uid){
		$command = new BackFlow();
		return $command->doTask($config,$uid);
	}
	/**
	 * 会签操作
	 * 
	 * @param  $config 参数信息
	 * @param  $uid  用户ID
	 */
	public function doSing($config,$uid){
		$command = new SingFlow();
		return $command->doTask($config,$uid);
	}
	
	/**
	 * 普通流程通过
	 * 
	 * @param  $config 参数信息
	 * @param  $uid  用户ID
	 */
	public function doSingEnt($config,$uid,$wf_actionid){
		$command = new SingFlow();
		return $command->doSingEnt($config,$uid,$wf_actionid);
	}
	/**
	 * 实例超级接口
	 * 
	 * @param  $wfid 工作流ID run_id
	 * @param  $uid  用户ID
	 */
	public function doSupEnd($wfid,$uid){
		$command = new SupFlow();
		return $command->doSupEnd($wfid,$uid);
	}
}