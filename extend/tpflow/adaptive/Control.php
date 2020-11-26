<?php
/**
 *+------------------
 * Tpflow 核心控制器
 *+------------------
 * Copyright (c) 2006~2018 http://cojz8.cn All rights reserved.
 *+------------------
 * Author: guoguo(1838188896@qq.com)
 *+------------------
 */
namespace tpflow\adaptive;

use tpflow\lib\unit;

Class Control{
	/**
	 * 结束流程接口
	 * @param $bill_table 表名称
	 * @param $bill_id id
	 */
	static function EndRun($user_id,$bill_table,$bill_id){
		//终止权限校验
		//1、所有人均可终止；2、单据发起人可以终止；3、指定uid可以终止；
		$wf_access_control = unit::gconfig('wf_access_control');
		$wf_access_control_uid = unit::gconfig('wf_access_control_uid');
		if($wf_access_control==2){
			$log = Log::RunLog($bill_id,$bill_table);//读取到log记录
			foreach($log as $k=>$v){
				if($v['btn']=='流程发起'){
					$access_uid = $v['uid'];
					break;
				}
			}
			if($user_id != $access_uid){
				return ['msg'=>'对不起您没有结束流程的权限~','code'=>'-1'];
			}
		}
		if($wf_access_control==3){
			if(!in_array($user_id,$wf_access_control_uid)){
				return ['msg'=>'对不起您没有结束流程的权限~','code'=>'-1'];
			}
		}
		//权限判断结束
		//终止流程及步骤
		$findwhere = [['from_id','=',$bill_id],['from_table','=',$bill_table]];
		$FindRun = Run::FindRun($findwhere);
		if(!$FindRun){
			return ['msg'=>'没有找到流程~','code'=>'-1'];
		}
		$end_flow = Flow::end_flow($FindRun['id']);
		if(!$end_flow){
			return ['msg'=>'结束流程失败~','code'=>'-1'];
		}
		$updatebill = Bill::updatebill($bill_table,$bill_id,0);
		if(!$end_flow){
			return ['msg'=>'更新单据信息出错~','code'=>'-1'];
		}
		return ['msg'=>'终止成功~','code'=>0];
	}
}