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
namespace tpflow\custom\think;

use think\facade\Db;
use tpflow\adaptive\Flow;
use tpflow\adaptive\Process;
use tpflow\adaptive\User;
use tpflow\adaptive\Entrust;
use tpflow\adaptive\Bill;


class AdapteeInfo{
	
	function AddRun($data)
	{
       return Db::name('run')->insertGetId($data);
	}
	function AddRunProcess($data)
	{
		return Db::name('run_process')->insertGetId($data);
	}
	function SearchRun($where=[],$field='*'){
		return Db::name('run')->where($where)->field($field)->select()->toArray();
	}
	function FindRunSign($where=[],$field='*'){
		return Db::name('run_sign')->where($where)->field($field)->find();
	}
	function FindRun($where=[],$field='*'){
		return Db::name('run')->where($where)->field($field)->find();
	}
	function FindRunProcess($where=[],$field='*'){
		return Db::name('run_process')->where($where)->field($field)->find();
	}
	function SearchRunProcess($where=[],$field='*'){
		return Db::name('run_process')->where($where)->field($field)->select();
	}
	/**
	 * 工作流列表
	 *
	 */
	function worklist()
	{
		$result = Db::name('run')->where('status',0)->select()->toArray();;
		foreach($result as $k=>$v)
		{
			$result[$k]['flow_name'] = Db::name('flow')->where('id',$v['flow_id'])->value('flow_name');
			$process = Db::name('run_process')->where('run_id',$v['id'])->where('run_flow_process',$v['run_flow_process'])->select();
			$sponsor_text= '';
			foreach($process as $p=>$s){
				$sponsor_text .=  $s['sponsor_text'].',';
			}
			$result[$k]['user'] = rtrim($sponsor_text,",");
		}
        return $result;
	}
	/**
	 * 接入工作流的类别
	 *
	 */
	function get_wftype()
	{
		$config = require ( BEASE_URL . '/config/common.php');//
		if($config['wf_type_mode']==0){
			return Db::query("select replace(TABLE_NAME,'".$config['prefix']."','')as name,TABLE_COMMENT as title from information_schema.tables where table_schema='".$config['database']."' and table_type='base table' and TABLE_COMMENT like '".$config['work_table']."%';");
		}else{
			return $config['wf_type_data'];
		}
		
	}
}