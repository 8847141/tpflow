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
	function SearchFlowProcess($where=[],$field='*',$order='',$limit=0){
		if($limit>0){
			return Db::name('flow_process')->where($where)->field($field)->order($order)->limit($limit)->select();
		}else{
			return Db::name('flow_process')->where($where)->field($field)->order($order)->select()->all();
		}
	}
	function EditFlowProcess($where,$data){
		return Db::name('flow_process')->where($where)->update($data);
	}
	function DelFlowProcess($where){
		return Db::name('flow_process')->where($where)->delete();
	}
	function AddFlowProcess($data)
    {
        return  Db::name('flow_process')->insertGetId($data);
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