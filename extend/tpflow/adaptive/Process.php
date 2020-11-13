<?php
/**
*+------------------
* Tpflow 工作流步骤
*+------------------
* Copyright (c) 2006~2018 http://cojz8.cn All rights reserved.
*+------------------
* Author: guoguo(1838188896@qq.com)
*+------------------ 
*/

namespace tpflow\adaptive;

use tpflow\lib\unit;

class Process{
	
	protected $mode ; 
    public function  __construct(){
		if(unit::gconfig('wf_db_mode')==1){
			$className = '\\tpflow\\custom\\think\\AdapteeProcess';
		}else{
			$className = unit::gconfig('wf_db_namespace').'AdapteeProcess';
		}
		$this->mode = new $className();
    }
	/**
	 * 根据ID获取流程信息
	 *
	 * @param $pid 步骤编号
	 */
	static function find($pid)
	{
		return (new Process())->mode->find($pid);
	}
	/**
	 * 根据ID获取流程信息
	 *
	 * @param $pid 步骤编号
	 */
	static function GetProcessInfo($pid,$run_id='')
	{
		$info = (new Process())->mode->find($pid);
		
		if($info['auto_person']==3){ //办理人员
			$ids = explode(",",$info['range_user_text']);
			$info['todo'] = ['ids'=>explode(",",$info['range_user_ids']),'text'=>explode(",",$info['range_user_text'])];
		}
		if($info['auto_person']==4){ //办理人员
			$info['todo'] = $info['auto_sponsor_text'];
		}
		if($info['auto_person']==5){ //办理角色
			$info['todo'] = $info['auto_role_text'];
		}
		if($info['auto_person']==6){ //办理角色
				$wf  =  Db::name('run')->find($run_id);
				$user_id = Bill::getbillvalue($wf['from_table'],$wf['from_id'],$wf_process['work_text']);
				$info['todo']= User::GetUserName($user_id);
			}
		return $info;
	}
	/**
	 * 同步步骤信息
	 *
	 * @param $pid 步骤编号
	 */
	static function GetProcessInfos($ids,$run_id)
	{
		return (new Process())->mode->GetProcessInfos($ids,$run_id);
	}
	/**
	 * 获取下个审批流信息
	 *
	 * @param $wf_type 单据表
	 * @param $wf_fid  单据id
	 * @param $pid   流程id
	 * @param $premode   上一个步骤的模式
	 **/
	static function GetNexProcessInfo($wf_type,$wf_fid,$pid,$run_id,$premode='')
	{
		return (new Process())->mode->GetNexProcessInfo($wf_type,$wf_fid,$pid,$run_id,$premode);
	}
	/**
	 * 获取前步骤的流程信息
	 *
	 * @param $runid
	 */
	static function GetPreProcessInfo($runid)
	{
		return (new Process())->mode->GetPreProcessInfo($runid);
	}
	/**
	 * 获取前步骤的流程信息
	 *
	 * @param $runid
	 */
	static function Getrunprocess($pid,$run_id)
	{
		return (new Process())->mode->Getrunprocess($pid,$run_id);
	}
	/**
	 * 同步模式下获取未办结的流程信息
	 *
	 * @param $run_id 运行中的ID
	 * @param $run_process 运行中的流程ID
	 */
	static function Getnorunprocess($run_id,$run_process)
	{
		return (new Process())->mode->Getnorunprocess($run_id,$run_process);
	}
	/**
	 * 获取第一个流程
	 *
	 * @param $wf_id
	 */
	static function getWorkflowProcess($wf_id) 
	{
		return (new Process())->mode->getWorkflowProcess($wf_id);
	}
	/**
	 * 流程日志
	 *
	 * @param $wf_fid
	 * @param $wf_type
	 */
	static function RunLog($wf_fid,$wf_type) 
	{
		return (new Process())->mode->RunLog($wf_fid,$wf_type);
	}
	/**
	 * 阻止重复提交
	 *
	 * @param $id
	 */
	static function run_check($id) 
	{
		return (new Process())->mode->run_check($id);
	}
	/**
	 *新增会签
	 *
	 *@param $config 参数信息
	 **/
	static function AddSing($config)
	{
		return (new Process())->mode->AddSing($config);
	}
	/**
	 *会签执行
	 *
	 * @param $sing_sign 会签ID
	 * @param $check_con  审核内容
	 **/
	static function EndSing($sing_sign,$check_con)
	{
		return (new Process())->mode->EndSing($sing_sign,$check_con);
	}
	/**
	 *更新会签信息
	 *
	 *@param $run_id 工作流run id
	 **/
	static function up_run_sing($run_id)
	{
		return (new Process())->mode->up_run_sing($run_id);
	}
	/**
	 *更新流程步骤信息
	 *
	 *@param $run_id 工作流ID
	 *@param $run_process 运行步骤
	 **/
	static function up_flow_press($run_id,$run_process)
	{
		return (new Process())->mode->up_flow_press($run_id,$run_process);
	}
	/**
	 *更新流程会签信息
	 *
	 *@param $run_id 工作流ID
	 *@param $sid 会签ID
	 **/
	static function up_flow_sing($run_id,$sid)
	{
		return (new Process())->mode->up_flow_sing($run_id,$sid);
	}
	/**
	 *获取sing_id
	 *
	 *@param $run_id 工作流ID
	 **/
	static function get_sing_id($run_id)
	{
		return (new Process())->mode->get_sing_id($run_id);
	}
	/**
	 *获取所有相关的流程步骤
	 *
	 *@param $uid 用户id
	 *@param $role 用户角色id
	 **/
	static function get_userprocess($uid,$role)
	{
		return (new Process())->mode->get_userprocess($uid,$role);
	}
}