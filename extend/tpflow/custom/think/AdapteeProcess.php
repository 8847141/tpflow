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

namespace tpflow\custom\think;;

use think\facade\Db;
use tpflow\adaptive\Flow;
use tpflow\adaptive\User;
use tpflow\adaptive\Entrust;
use tpflow\adaptive\Bill;
use tpflow\adaptive\Info;
use tpflow\adaptive\Log;

class AdapteeProcess{
	
	/**
	 * flow_process find
	 *
	 * @param $id 步骤编号
	 * @param $field 字段过滤
	 */
	function find($id,$field='*'){
		return Db::name('flow_process')->field($field)->find($id);
	}
	
	/**
	 * 根据ID获取流程信息
	 *
	 * @param $pid 步骤编号
	 */
	function GetProcessInfo($pid,$run_id='')
	{
		$info = $this->find($pid);
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
	function GetProcessInfos($ids,$run_id)
	{
		$info = Db::name('flow_process')
				->field('id,process_name,process_type,process_to,auto_person,auto_sponsor_ids,auto_role_ids,auto_sponsor_text,auto_role_text,range_user_ids,range_user_text,is_sing,is_back,wf_mode,wf_action,work_ids,work_text')
				->where('id','in',$ids)
				->select();
		foreach($info as $k=>$v){
			if($v['auto_person']==3){ //办理人员
				$ids = explode(",",$info['range_user_text']);
				$info[$k]['todo'] = ['ids'=>explode(",",$v['range_user_ids']),'text'=>explode(",",$v['range_user_text'])];
			}
			if($v['auto_person']==4){ //办理人员
				$info[$k]['todo'] = $v['auto_sponsor_text'];
			}
			if($v['auto_person']==5){ //办理角色
				$info[$k]['todo'] = $v['auto_role_text'];
			}
			if($v['auto_person']==6){ //办理角色
				$wf  =  Db::name('run')->find($run_id);
				$user_id = Bill::getbillvalue($wf['from_table'],$wf['from_id'],$wf_process['work_text']);
				$user_info = User::GetUserInfo($user_id);
				$info['user_info']= $user_info;
				$info[$k]['todo']= $user_info['username'];
			}
		}
		
		return $info;
	}
	/**
	 * 获取下个审批流信息
	 *
	 * @param $wf_type 单据表
	 * @param $wf_fid  单据id
	 * @param $pid   流程id
	 * @param $premode   上一个步骤的模式
	 **/
	function GetNexProcessInfo($wf_type,$wf_fid,$pid,$run_id,$premode='')
	{
		if($pid==''){
			return [];
		}
		$nex = Db::name('flow_process')->find($pid);
	
		//先判断下上一个流程是什么模式
		if($nex['process_to'] !=''){
		$nex_pid = explode(",",$nex['process_to']);
		$out_condition = json_decode($nex['out_condition'],true);
			//加入同步模式 2为同步模式
			/*
			 * 2019年1月28日14:30:52
			 *1、加入同步模式
			 *2、先获取本步骤信息
			 *3、获取本步骤的模式
			 *4、根据模式进行读取
			 *5、获取下一步骤需要的信息
			 **/
			switch ($nex['wf_mode']){
			case 0:
			  $process = self::GetProcessInfo($nex_pid,$run_id);
			  break;
			case 1:
				//多个审批流
				foreach($out_condition as $key=>$val){
					$where =implode(",",$val['condition']);
					//根据条件寻找匹配符合的工作流id
					$info = Bill::checkbill($wf_type,$wf_fid,$where);
					if($info){
						$nexprocessid = $key; //获得下一个流程的id
						break;	
					}
				}
				$process = self::GetProcessInfo($nexprocessid,$run_id);
			   break;
			case 2:
				$process = self::GetProcessInfos($nex_pid,$run_id);
			  break;
			}
		}else{
			$process = ['auto_person'=>'','id'=>'','process_name'=>'END','todo'=>'结束'];
		}
		return $process;
	}
	/**
	 * 获取前步骤的流程信息
	 *
	 * @param $runid
	 */
	function GetPreProcessInfo($runid)
	{
		$pre = [];
		$pre_n = Db::name('run_process')->find($runid);
		//获取本流程中小于本次ID的步骤信息
		$pre_p = Db::name('run_process')
			 ->where('run_flow',$pre_n['run_flow'])
			 ->where('run_id',$pre_n['run_id'])
			 ->where('id','<',$pre_n['id'])
			 ->field('run_flow_process')->select();
		//遍历获取小于本次ID中的相关步骤
		foreach($pre_p as $k=>$v){
			$pre[] = Db::name('flow_process')->where('id',$v['run_flow_process'])->find();
		}
		$prearray = [];
		if(count($pre)>=1){
			$prearray[0] = '退回制单人修改';
			foreach($pre as $k => $v){
				if($v['auto_person']==4){ //办理人员
					$todo = $v['auto_sponsor_text'];
				}
				if($v['auto_person']==5){ //办理角色
					$todo = $v['auto_role_text'];
				}
				$prearray[$v['id']] = $v['process_name'].'('.$todo.')';
			}
			}else{
			$prearray[0] = '退回制单人修改';	
		}
		return $prearray;
	}
	/**
	 * 获取前步骤的流程信息
	 *
	 * @param $runid
	 */
	function Getrunprocess($pid,$run_id)
	{
		$pre_n = Db::name('run_process')->where('run_id',$run_id)->where('run_flow_process',$pid)->find();
		return $pre_n;
	}
	/**
	 * 同步模式下获取未办结的流程信息
	 *
	 * @param $run_id 运行中的ID
	 * @param $run_process 运行中的流程ID
	 */
	function Getnorunprocess($run_id,$run_process)
	{
		$no_run_list = Db::name('run_process')->where('run_id',$run_id)->where('status',0)->where('id','neq',$run_process)->select();
		return $no_run_list;
	}
	/**
	 * 获取第一个流程
	 *
	 * @param $wf_id
	 */
	function getWorkflowProcess($wf_id) 
	{
		$flow_process = Db::name('flow_process')->where('is_del',0)->where('flow_id',$wf_id)->select();
		//找到 流程第一步
        $flow_process_first = array();
        foreach($flow_process as $value)
        {
            if($value['process_type'] == 'is_one')
            {
                $flow_process_first = $value;
                break;
            }
        }
		if(!$flow_process_first)
        {
            return  false;
        }
		return $flow_process_first;
	}
	/**
	 * 流程日志
	 *
	 * @param $wf_fid
	 * @param $wf_type
	 */
	function RunLog($wf_fid,$wf_type) 
	{
		$type = ['Send'=>'流程发起','ok'=>'同意提交','Back'=>'退回修改','SupEnd'=>'终止流程','Sing'=>'会签提交','sok'=>'会签同意','SingBack'=>'会签退回','SingSing'=>'会签再会签'];
		$run_log = Db::name('run_log')->where('from_id',$wf_fid)->where('from_table',$wf_type)->select()->all();
		foreach($run_log as $k=>$v)
        {
			$run_log[$k]['btn'] =$type[$v['btn']];
			$run_log[$k]['user'] = User::GetUserName($v['uid']);
        }
		return $run_log;
	}
	/**
	 * 阻止重复提交
	 *
	 * @param $id
	 */
	function run_check($id) 
	{
		return Db::name('run_process')->where('id',$id)->value('status');

	}
	/**
	 *新增会签
	 *
	 *@param $config 参数信息
	 **/
	function AddSing($config)
	{
		$data = [
			'run_id'=>$config['run_id'],
			'run_flow'=>$config['flow_id'],
			'run_flow_process'=>$config['run_process'],
			'uid'=>$config['wf_singflow'],
			'dateline'=>time()
		];
		$run_sign = Db::name('run_sign')->insertGetId($data);
		if(!$run_sign){
            return  false;
        }
        return $run_sign;	
	}
	/**
	 *会签执行
	 *
	 * @param $sing_sign 会签ID
	 * @param $check_con  审核内容
	 **/
	function EndSing($sing_sign,$check_con)
	{
		return Db::name('run_sign')->where('id',$sing_sign)->update(['is_agree'=>1,'content'=>$check_con,'dateline'=>time()]);
	}
	/**
	 *更新会签信息
	 *
	 *@param $run_id 工作流run id
	 **/
	function up_run_sing($run_id)
	{
		return Db::name('run')->where('id',$run_id)->update(['is_sing'=>0]);
	}
	/**
	 *更新流程步骤信息
	 *
	 *@param $run_id 工作流ID
	 *@param $run_process 运行步骤
	 **/
	function up_flow_press($run_id,$run_process)
	{
		return Db::name('run')->where('id',$run_id)->update(['run_flow_process'=>$run_process]);
	}
	/**
	 *更新流程会签信息
	 *
	 *@param $run_id 工作流ID
	 *@param $sid 会签ID
	 **/
	function up_flow_sing($run_id,$sid)
	{
		return Db::name('run')->where('id',$run_id)->update(['is_sing'=>1,'sing_id'=>$sid,'endtime'=>time()]);
	}
	/**
	 *获取sing_id
	 *
	 *@param $run_id 工作流ID
	 **/
	function get_sing_id($run_id)
	{
		return Db::name('run')->where('id',$run_id)->value('sing_id');
	}
	/**
	 *获取所有相关的流程步骤
	 *
	 *@param $uid 用户id
	 *@param $role 用户角色id
	 **/
	function get_userprocess($uid,$role)
	{
		return Db::name('flow_process')->alias('f')
			->join('flow w','f.flow_id = w.id')
			->where('find_in_set(:asi,f.auto_sponsor_ids)',['asi'=>$uid])
			->whereOr('find_in_set(:rui,f.range_user_ids)',['rui'=>$uid])
			->whereOr('find_in_set(:ari,f.auto_role_ids)',['ari'=>$role])
			->field('f.id,f.process_name,f.flow_id,w.flow_name')
			->select();;
	}
}