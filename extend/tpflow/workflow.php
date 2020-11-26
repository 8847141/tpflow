<?php
/**
 *+------------------
 * Tpflow 工作流核心驱动类
 *+------------------
 * Copyright (c) 2006~2018 http://cojz8.cn All rights reserved.
 *+------------------
 * Author: guoguo(1838188896@qq.com)
 *+------------------
 */

namespace tpflow;



define('BEASE_URL', realpath ( dirname ( __FILE__ ) ) );
define('ROOT_PATH',root_path());

//数据库操作
use tpflow\adaptive\Info;
use tpflow\adaptive\Flow;
use tpflow\adaptive\Process;
use tpflow\adaptive\User;
use tpflow\adaptive\Work;
use tpflow\adaptive\Entrust;
use tpflow\adaptive\Log;
use tpflow\adaptive\Bill;
use tpflow\lib\lib;

//类库
use tpflow\service\TaskService;
//消息
use tpflow\msg\mail;

	/**
	 * 根据单据ID获取流程信息
	 */
	class workflow{
		
		/**
		 *流程发起
		 *
		 * @param  $wf_id 实例化流程id 
		 * @param  $wf_fid  实例化单据id
		 * @param  $check_con 提交意见 
		 * @param  $uid    用户ID
		 **/
		function startworkflow($wf_id,$wf_fid,$check_con,$uid)
		{
			if ($wf_id == '' || $wf_fid == ''|| $uid == '') {
				return ['msg'=>'参数不完整！','code'=>'-1'];
			}
			//判断流程是否存在
			$wf = Flow::getWorkflow($wf_id);
			if(!$wf){
				return ['msg'=>'未找到工作流！','code'=>'-1'];
			}
			$wf_type  = $wf['type'];
			//判断单据是否存在
			$getbill = Bill::getbill($wf_type,$wf_fid);
			if(!$getbill){
				return ['msg'=>'单据不存在！','code'=>'-1'];
			}
			//根据流程获取流程第一个步骤
			$wf_process = Process::getWorkflowProcess($wf_id);
			if(!$wf_process){
				return ['msg'=>'流程设计出错，未找到第一步流程，请联系管理员！','code'=>'-1'];
			}
			//满足要求，发起流程
			$wf_run = Info::addWorkflowRun($wf_id,$wf_process['id'],$wf_fid,$wf_type,$uid);
			if(!$wf_run){
				return ['msg'=>'流程发起失败，数据库操作错误！！','code'=>'-1'];
			}
			//添加流程步骤日志
			$wf_process_log = Info::addWorkflowProcess($wf_id,$wf_process,$wf_run,$uid);
			if(!$wf_process_log){
				return ['msg'=>'流程步骤操作记录失败，数据库错误！！！','code'=>'-1'];
			}
			//更新单据状态
			$bill_update = Bill::updatebill($wf_type,$wf_fid,1);
			if(!$bill_update){
				return ['msg'=>'流程步骤操作记录失败，数据库错误！！！','code'=>'-1'];
			}
			$run_log = Log::AddrunLog($uid,$wf_run,['wf_id'=>$wf_id,'wf_fid'=>$wf_fid,'wf_type'=>$wf_type,'check_con'=>$check_con],'Send');
			return ['run_id'=>$wf_run,'msg'=>'success','code'=>'1'];
		}
		/**
		  * 流程状态查询
		  *
		  * @$wf_fid 单据编号
		  * @$wf_type 单据表 
		  * @$userinfo 用户的uid，用户的role 
		  **/
		function workflowInfo($wf_fid,$wf_type,$userinfo=[])
		{
			if ($wf_fid == '' || $wf_type == '') {
				return ['msg'=>'单据编号，单据表不可为空！','code'=>'-1'];
			}
			return Info::workflowInfo($wf_fid,$wf_type,$userinfo);
		}
		/*
		 * 获取下一步骤信息
		 *
		 * @param  $config 参数信息
		 * @param  $uid 用户ID
		 **/
		function workdoaction($config,$uid)
		{
			if( @$config['run_id']=='' || @$config['run_process']==''){
		       	throw new \Exception ( "config参数信息不全！" );
			}
			$taskService = new TaskService();//工作流服务
			$wf_actionid = $config['submit_to_save'];
			$sing_st = $config['sing_st'];
			if($sing_st == 0){
				$run_check = Process::run_check($config['run_process']);//校验流程状态
				if($run_check==2){
					return ['msg'=>'该业务已办理，请勿重复提交！','code'=>'-1'];
				}
				if ($wf_actionid == "ok") {//提交处理
					$ret = $taskService->doTask($config,$uid);
				} else if ($wf_actionid == "back") {//退回处理
					$ret = $taskService->doBack($config,$uid);
				} else if ($wf_actionid == "sing") {//会签
					$ret = $taskService->doSing($config,$uid);
				} else { //通过
					throw new \Exception ( "参数出错！" );
				}
			}else{
				$ret = $taskService->doSingEnt($config,$uid,$wf_actionid);
			}
			return $ret;
		}
		
		/*
		 * FlowDesc API
		 *
		 **/
		
		function FlowApi($wf_type,$data='')
		{
			if ($wf_type == "List") {
					$info = Flow::GetFlow();		//获取工作流列表
				} else if ($wf_type == "AddFlow") {
					$info = Flow::AddFlow($data); //新增工作流
				} else if ($wf_type == "EditFlow") {
					$info = Flow::EditFlow($data);//更新工作流
				} else if ($wf_type == "GetFlowInfo")  { 
					$info = Flow::getWorkflow($data); //获取工作流详情
				}else{
					throw new \Exception ( "参数出错！" );
				}
			return $info;
		}
		/*
		 * FlowLog API
		 *
		 **/
		function FlowLog($logtype,$wf_fid,$wf_type)
		{
			
			if ($logtype == "logs") {
					$info = Log::RunLog($wf_fid,$wf_type);//获取log
					$html ='
					 <style type="text/css">
						.new_table{border-collapse: collapse;margin: 0 auto;text-align: center;}
						.new_table td, table th{border: 1px solid #cad9ea;color: #666;height: 30px;}
						.new_table thead th{background-color: #CCE8EB;width: 100px;}
						.new_table tr:nth-child(odd){background: #fff;}
						.new_table tr:nth-child(even){background: #F5FAFA;}
					</style>
					<table class="new_table" style="margin-top:5px"><tr><tr><td>审批人</td><td>审批意见</td><td>审批操作</td><td>审批时间</td></tr></tr>';
					foreach($info as $k=>$v){
						$down = '';
						if($v['art']<>''){
							$down = '附件：<a class="btn btn-success" href="/uploads/'.$v['art'].'" target="download">下载</a>';
						}
						$html .='<tr><td>'.$v['user'].'</td><td>'.$v['content'].$down.'</td><td>'.$v['btn'].'</td><td>'.date('m-d H:i',$v['dateline']).'</td></tr>';
					}
					$html .='</table>';
				}else{
					throw new \Exception ( "参数出错！" );
				}
			return ['json'=>$info,'html'=>$html];
		}
		/*
		 * ProcessDesc API
		 * 
		 **/
		
		function ProcessApi($ProcessType,$flow_id,$data='')
		{
			if ($ProcessType == "All") {
					$info = Flow::ProcessAll($flow_id); 
				} else if ($ProcessType == "ProcessDel") {       //删除步骤
					$info = Flow::ProcessDel($flow_id,$data);
				} else if ($ProcessType == "ProcessDelAll") {    //删除步骤
					$info = Flow::ProcessDelAll($flow_id);
				} else if ($ProcessType == "ProcessAdd")  {      //新增步骤
					$info = Flow::ProcessAdd($flow_id); 
				} else if ($ProcessType == "ProcessLink")  { 
					$info = Flow::ProcessLink($flow_id,$data); //保存设计样式
				} else if ($ProcessType == "ProcessAttSave")  { 
					$info = Flow::ProcessAttSave($flow_id,$data); //保存步骤属性
				} else if ($ProcessType == "ProcessAttView")  { 
					$info = Flow::ProcessAttView($flow_id,$data); //查看属性设计
				}else{
					throw new \Exception ( "参数出错！" );
				}
			return $info;
		}
		
		/*
		 * SuperApi API
		 * 
		 **/
		function SuperApi($stype,$key,$data='')
		{
			$taskService = new TaskService();//工作流服务
			if ($stype == "WfEnd") {
					$ret = $taskService->doSupEnd($key,$data); //终止工作流
				}else if ($stype == "Role") {    
					$ret = User::GetRole();
				}else if ($stype == "CheckFlow") {    
					$ret = Flow::CheckFlow($key);
				}else{
					throw new \Exception ( "参数出错！" );
				}
			return $ret;
		}

		function getprocessinfo($pid,$run_id){
			if( @$pid=='' || @$run_id ==''){
		       	throw new \Exception ( "config参数信息不全！" );
			}
			$wf_process = Run::FindRunProcess([['run_id','=',$run_id],['run_flow_process','=',$pid],['status','=',0]]);
			if($wf_process['auto_person']==3){
				$todo = $wf_process['sponsor_ids'].'*%*'.$wf_process['sponsor_text'];
				}else{
				$todo = '';
			}
			return $todo;
		}
		
		function send_mail()
		{
			$mail = new SendMail();
			$mail->setServer("smtp.qq.com", "1838188896@qq.com", "pass");
			$mail->setFrom("1838188896@qq.com");
			$mail->setReceiver("632522043@qq.com");
			$mail->setReceiver("632522043@qq.com");
			$mail->setMailInfo("test", "<b>test</b>");
			$mail->sendMail();
		}
		
}
