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
	function finds($ids,$field='*'){
		return Db::name('flow_process')->field($field)->where('id','in',$ids)->select();
	}
	function FindRun($id,$field='*'){
		return Db::name('run')->field($field)->find($id);
	}
	function FindRunProcess($id,$field='*'){
		return Db::name('run_process')->field($field)->find($id);
	}
	function SearchRunProcess($where=[],$field='*'){
		return Db::name('run_process')->where($where)->field($field)->select();
	}
	function SearchFlowProcess($where=[],$field='*',$order='',$limit=0){
		if($limit>0){
			return Db::name('flow_process')->where($where)->field($field)->order($order)->limit($limit)->select();
		}else{
			return Db::name('flow_process')->where($where)->field($field)->order($order)->select()->all();
		}
	}
	function EditRun($id,$data){
		return Db::name('run')->where('id',$run_id)->update($data);
	}
	function Getrunprocess($pid,$run_id)
	{
		return Db::name('run_process')->where('run_id',$run_id)->where('run_flow_process',$pid)->find();
	}
	function AddSing($data)
	{
		return Db::name('run_sign')->insertGetId($data);
	}
	function EndSing($sing_sign,$check_con)
	{
		return Db::name('run_sign')->where('id',$sing_sign)->update(['is_agree'=>1,'content'=>$check_con,'dateline'=>time()]);
	}
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