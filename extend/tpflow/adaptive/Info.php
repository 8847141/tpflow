<?php
/**
*+------------------
* Tpflow 流信息处理
*+------------------
* Copyright (c) 2006~2018 http://cojz8.cn All rights reserved.
*+------------------
* Author: guoguo(1838188896@qq.com)
*+------------------ 
*/
namespace tpflow\adaptive;

use tpflow\lib\unit;

class Info{
	
	protected $mode ; 
    public function  __construct(){
		if(unit::gconfig('wf_db_mode')==1){
			$className = '\\tpflow\\custom\\think\\AdapteeInfo';
		}else{
			$className = unit::gconfig('wf_db_namespace').'AdapteeInfo';
		}
		$this->mode = new $className();
    }
	/**
	 * 添加工作流
	 *
	 * @param $wf_id  流程主ID
	 * @param $wf_process 流程信息
	 * @param $wf_fid  业务id
	 * @param $wf_type 业务表名
	 */
	public static function addWorkflowRun($wf_id,$wf_process,$wf_fid,$wf_type,$uid)
	{
		return (new Info())->mode->addWorkflowRun($wf_id,$wf_process,$wf_fid,$wf_type,$uid);
	}
	/**
	 * 添加运行步骤信息
	 *
	 * @param $wf_id  流程主ID
	 * @param $wf_process 流程信息
	 * @param $run_id  运行的id
	 * @param $wf_type 业务表名
	 */
	public static function addWorkflowProcess($wf_id,$wf_process,$run_id,$uid,$todo = '')
	{
		return (new Info())->mode->addWorkflowProcess($wf_id,$wf_process,$run_id,$uid,$todo);
	}
	/**
	 * 缓存信息
	 *
	 * @param $wf_fid  单据编号
	 * @param $flow_process 流程信息
	 * @param $run_id  运行的id
	 * @param $wf 流程信息
	 */
	public static function addWorkflowCache($run_id,$wf,$flow_process,$wf_fid)
	{
		return (new Info())->mode->addWorkflowCache($run_id,$wf,$flow_process,$wf_fid);
	}
	/**
	 * 根据单据ID，单据表 获取流程信息
	 *
	 * @param $run_id  运行的id
	 * @param $wf_type 业务表名
	 */
	public static function workflowInfo($wf_fid,$wf_type,$userinfo) {
		return (new Info())->mode->workflowInfo($wf_fid,$wf_type,$userinfo);
	}
	public static function nexnexprocessinfo($wf_mode,$npi){
		return (new Info())->mode->nexnexprocessinfo($wf_mode,$npi);
	}
	
	/**
	 * 根据单据ID，单据表 获取流程信息
	 *
	 * @param $run_id  运行的id
	 * @param $wf_type 业务表名
	 */
	public static function workrunInfo($run_id) {
		return (new Info())->mode->workrunInfo($run_id);
	}
	/**
	 * 工作流列表
	 *
	 */
	public static function worklist()
	{
		return (new Info())->mode->worklist();
	}
	/**
	 * 接入工作流的类别
	 *
	 */
	public static function get_wftype()
	{
		return (new Info())->mode->get_wftype();
	}
}