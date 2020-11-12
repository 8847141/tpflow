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

class Flow
{
	protected $mode ; 
    public function  __construct(){
		if(unit::gconfig('wf_db_mode')==1){
			$className = '\\tpflow\\custom\\think\\AdapteeFlow';
		}else{
			$className = unit::gconfig('wf_db_namespace').'AdapteeFlow';
		}
		$this->mode = new $className();
    }
    /**
     * 获取类别工作流
     *
     * @param $wf_type
     */
   static function getWorkflowByType($wf_type)
    {
       return (new Flow())->mode->getWorkflowByType($wf_type);
    }

    /**
     * 获取流程信息
     *
     * @param $fid
     */
   static function GetFlowInfo($fid)
    {
       return (new Flow())->mode->GetFlowInfo($fid);
    }

    /**
     * 判断工作流是否存在
     *
     * @param $wf_id
     */
   static function getWorkflow($wf_id)
    {
       return (new Flow())->mode->getWorkflow($wf_id);
    }

    /**
     * 获取步骤信息
     *
     * @param $id
     */
   static function getflowprocess($id)
    {
       return (new Flow())->mode->getflowprocess($id);
    }

    /**
     * API获取工作流列表
     * API接口调用
     */
   static function GetFlow($info = '')
    {
       return (new Flow())->mode->GetFlow($info);
    }

    /**
     * API 新增工作流
     * @param $data POST提交的数据
     */
   static function AddFlow($data)
    {
        return (new Flow())->mode->AddFlow($data);
    }

    /**
     * API 编辑工作流
     * @param $data POST提交的数据
     */
   static function EditFlow($data)
    {
        return (new Flow())->mode->EditFlow($data);
    }
	 /**
     * 获取所有步骤信息
     * @param $flow_id 
     */
   static function ProcessAll($flow_id)
    {
       return (new Flow())->mode->ProcessAll($flow_id);
    }
	/**
     * 删除步骤信息
     * @param $flow_id 
	 * @param $process_id 
     */
   static function ProcessDel($flow_id, $process_id)
    {
       return (new Flow())->mode->ProcessDel($flow_id, $process_id);
    }
	/**
     * 删除步骤信息
     * @param $flow_id 
     */
   static function ProcessDelAll($flow_id)
    {
       return (new Flow())->mode->ProcessDelAll($flow_id);
    }
	/**
     * 新增步骤信息
     * @param $flow_id 
     */
   static function ProcessAdd($flow_id)
    {
       return (new Flow())->mode->ProcessAdd($flow_id);
    }
	/**
     * 步骤连接
     * @param $flow_id 
	 * @param $process_info 
     */
   static function ProcessLink($flow_id, $process_info)
    {
       return (new Flow())->mode->ProcessLink($flow_id, $process_info);
    }
	/**
     * 属性保存
     * @param $process_id 
	 * @param $datas 
     */
   static function ProcessAttSave($process_id, $datas)
    {
        return (new Flow())->mode->ProcessAttSave($process_id, $datas);
    }
	/**
     * 属性查看
	 * @param $process_id
     */
   static function ProcessAttView($process_id)
    {
       return (new Flow())->mode->ProcessAttView($process_id);
    }
	/**
     * 步骤逻辑检查
     * @param $wfid 
     */
	public  static function CheckFlow($wfid)
	{
		return (new Flow())->mode->CheckFlow($wfid);
	}
	
	/**
	 *结束工作流主状态
	 *
	 *@param $run_flow_process 工作流ID
	 **/
	public static function end_flow($run_id)
	{
		return (new Flow())->mode->end_flow($run_id);
	}
	/**
	 *结束工作流步骤信息
	 *
	 *@param $run_flow_process 工作流ID
	 **/
	public static function end_process($run_process,$check_con)
	{
		return (new Flow())->mode->end_process($run_process,$check_con);
	}
	/**
	 *更新流程主信息
	 *
	 *@param $run_flow_process 工作流ID
	 **/
	public static function up($run_id,$flow_process)
	{
		return (new Flow())->mode->up($run_id,$flow_process);
	}
}