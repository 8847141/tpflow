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
	 * 流程日志
	 *
	 * @param $wf_fid
	 * @param $wf_type
	 */
	static function RunLog($wf_fid,$wf_type) 
	{
		$type = ['Send'=>'流程发起','ok'=>'同意提交','Back'=>'退回修改','SupEnd'=>'终止流程','Sing'=>'会签提交','sok'=>'会签同意','SingBack'=>'会签退回','SingSing'=>'会签再会签'];
		$run_log = (new Log())->mode->SearchRunLog($wf_fid,$wf_type) ;
		foreach($run_log as $k=>$v)
        {
			$run_log[$k]['btn'] =$type[$v['btn']];
			$run_log[$k]['user'] = User::GetUserName($v['uid']);
        }
		return $run_log;
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
		$work_return ='';
		if($btn<>'Send' && $btn<>'SupEnd'){
			$work_return = Work::WorkApi($config);//在日志记录前加载节点钩子
		}
		 if (!isset($config['art'])) {
               $config['art'] = '';
         }
		$run_log_data = array(
                'uid'=>$uid,
				'from_id'=>$config['wf_fid'],
				'from_table'=>$config['wf_type'],
                'run_id'=>$run_id,
                'content'=>$config['check_con'],
				'work_info'=>$work_return,
				'art'=>$config['art'],
                'btn'=>$btn,
                'dateline'=>time()
            );
		return (new Log())->mode->AddrunLog($run_log_data);
	}
}