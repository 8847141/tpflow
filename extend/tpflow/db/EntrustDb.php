<?php
/**
*+------------------
* Tpflow 节点事务处理
*+------------------
* Copyright (c) 2006~2020 http://cojz8.cn All rights reserved.
*+------------------
* Author: guoguo(1838188896@qq.com)
*+------------------
*/
namespace tpflow\db;
use think\facade\Db;

class EntrustDb{
	
	/**
     * API 查询
     * @param $data POST提交的数据
     */
    public static function lists()
    {
		return Db::name('entrust')->select();
    }
	/**
     * API 查询
     * @param $data POST提交的数据
     */
    public static function find($id)
    {
		$info = Db::name('entrust')->find($id);
		$info['entrust_stime'] = date('Y-m-d',$info['entrust_stime'])."T".date('H:i:s',$info['entrust_stime']);
		$info['entrust_etime'] = date('Y-m-d',$info['entrust_etime'])."T".date('H:i:s',$info['entrust_etime']);
		$info['type'] = $info['flow_process']."@".$info['flow_id'];
		$info['userinfo'] = $info['entrust_user']."@".$info['entrust_name'];
		return $info;
    }
	/**
     * API 新增
     * @param $data POST提交的数据
     */
    public static function Add($data)
    {
		$data['entrust_stime'] = strtotime($data['entrust_stime']);
		$data['entrust_etime'] = strtotime($data['entrust_etime']);
		$type = explode("@",$data['type']);
		$data['flow_process'] =$type[0];
		$data['flow_id'] =$type[1];
		$user = explode("@",$data['userinfo']);
		$data['entrust_user'] =$user[0];
		$data['entrust_name'] =$user[1];
		unset($data['userinfo']);
		unset($data['type']);
		$data['add_time'] =time();
		if($data['id']!=''){
			 $ret = Db::name('entrust')->update($data);
		}else{
			 $ret = Db::name('entrust')->insertGetId($data);
		}
        if ($ret) {
            return ['code' => 0, 'data' => $ret];
        } else {
            return ['code' => 1, 'data' => 'Db0001-写入数据库出错！'];
        }
    }
}