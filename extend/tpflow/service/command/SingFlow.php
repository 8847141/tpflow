<?php
/**
*+------------------
* Tpflow 会签模块
*+------------------ 
* Copyright (c) 2006~2018 http://cojz8.cn All rights reserved.
*+------------------
* Author: guoguo(1838188896@qq.com)
*+------------------
*/
namespace tpflow\service\command;

//数据库操作
use tpflow\db\InfoDb;
use tpflow\db\FlowDb;
use tpflow\db\ProcessDb;
use tpflow\db\LogDb;

class SingFlow{
	/**
	 * 回退工作流
	 * 
	 * @param  $config 参数信息
	 * @param  $uid  用户ID
	 */
	public function doTask($config,$uid) {
		$run_process = $config['run_process'];
		$run_id = $config['run_id'];
		if($config['sup']=='1'){
			$check_con = '[管理员代办]'.$config['check_con'];
			$config['check_con'] = '[管理员代办]'.$config['check_con'];
		}else{
			$check_con = $config['check_con'];
		}
		$sid = ProcessDb::AddSing($config);
		//结束当前流程，给个会签标志
		$end = ProcessDb::up_flow_sing($run_id,$sid);
		//结束process
		$end = FlowDb::end_process($run_process,$check_con);
		//加入会签
		$run_log = LogDb::AddrunLog($uid,$run_id,$config,'Sing');
		//日志记录
		return ['msg'=>'success!','code'=>'0'];
	}
	/**
	 *会签确认
	 *
	 * @param $config 参数信息
	 * @param $uid  用户ID
	 * @param $wf_actionid 操作按钮值
	 **/
	public function doSingEnt($config,$uid,$wf_actionid)
	{
		$sing_id = ProcessDb::get_sing_id($config['run_id']);
		ProcessDb::EndSing($sing_id,$config['check_con']);//结束当前会签
		if ($wf_actionid == "sok") {//提交处理
			if($config['npid'] !=''){
				/*
				 * 2019年1月27日21:20:13
				 ***/
				$nex_pid = explode(",",$config['npid']);
				foreach($nex_pid as $v){
					$wf_process = ProcessDb::GetProcessInfo($v,$config['run_id']);
					$add_process = InfoDB::addWorkflowProcess($config['flow_id'],$wf_process,$config['run_id'],$uid);	
				}
				ProcessDb::up_flow_press($config['run_id'],$config['npid']);
			}else{
				$bill_update = Bill::updatebill($config['wf_type'],$config['wf_fid'],2);
				if(!$bill_update){
					return ['msg'=>'流程步骤操作记录失败，数据库错误！！！','code'=>'-1'];
				}
			}
			ProcessDb::up_run_sing($config['run_id']);
			$run_log = LogDb::AddrunLog($uid,$config['run_id'],$config,'sok');
			if(!$run_log){
					return ['msg'=>'消息记录失败，数据库错误！！！','code'=>'-1'];
				}
			//日志记录
		}else if($wf_actionid == "sback") {//退回处理
			//判断是否是第一步，第一步：更新单据，发起修改，不是第一步，写入新的工作流
			$wf_backflow = $config['wf_backflow'];//退回的步骤ID，如果等于0则默认是第一步
			
			if($wf_backflow==0){
				$back = true;
				}else{
				$back =false;
			}
			if($back){//第一步
				//更新单据状态
				$bill_update = Bill::updatebill($config['wf_type'],$config['wf_fid'],0);
				if(!$bill_update){
					return ['msg'=>'流程步骤操作记录失败，数据库错误！！！','code'=>'-1'];
				}
				$run_log = LogDb::AddrunLog($uid,$config['run_id'],$config,'SingBack');
				ProcessDb::up_run_sing($config['run_id']);
				//日志记录
			}else{ //结束流程
				$wf_process = ProcessDb::GetProcessInfo($wf_backflow);
				$wf_run_process = InfoDB::addWorkflowProcess($config['flow_id'],$wf_process,$config['run_id'],$uid);
				ProcessDb::up_run_sing($config['run_id']);
				//消息通知发起人
				$run_log = LogDb::AddrunLog($uid,$config['run_id'],$config,'SingBack');
				if(!$run_log){
						return ['msg'=>'消息记录失败，数据库错误！！！','code'=>'-1'];
					}
			}
			//日志记录
		} else if ($wf_actionid == "ssing") {//会签
			//日志记录
			$run_log = LogDb::AddrunLog($uid,$config['run_id'],$config,'SingSing');
			$sid = ProcessDb::AddSing($config);
			$end = ProcessDb::up_flow_sing($config['run_id'],$sid);
			//发起新的会签
		} else { //通过
			throw new \Exception ("参数出错！");
		}
		return ['msg'=>'success!','code'=>'0'];
	}
}