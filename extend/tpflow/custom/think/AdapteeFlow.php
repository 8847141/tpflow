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

class AdapteeFlow
{
	/**
	 * flow find
	 *
	 * @param $id 步骤编号
	 * @param $field 字段过滤
	 */
	function find($id,$field='*'){
		return Db::name('flow')->field($field)->find($id);
	}
	/**
     * API 新增工作流
     * @param $data POST提交的数据
     */
   function AddFlow($data)
    {
        return Db::name('flow')->insertGetId($data);
    }
	function AddFlowProcess($data)
    {
        return  Db::name('flow_process')->insertGetId($data);
    }
    /**
     * API 编辑工作流
     * @param $data POST提交的数据
     */
   function EditFlow($data)
    {
       return Db::name('flow')->update($data);
    }
	function SearchFlow($where=[],$field='*'){
		return Db::name('flow')->where($where)->field($field)->select();
	}
	
	function SearchFlowProcess($where=[],$field='*',$order='',$limit=0){
		if($limit>0){
			return Db::name('flow_process')->where($where)->field($field)->order($order)->limit($limit)->select();
		}else{
			return Db::name('flow_process')->where($where)->field($field)->order($order)->select()->all();
		}
	}
    /**
     * API获取工作流列表
     * API接口调用
     */
   function GetFlow()
    {
		$list = Db::name('flow')->order('id desc')->where('is_del', '0')->paginate('10');
		$list->each(function ($item, $key) {
			$item['edit'] = Db::name('run')->where('flow_id', $item['id'])->where('status', '0')->value('id');
			return $item;
		});
        return $list;
    }
	function EditFlowProcess($where,$data){
		return Db::name('flow_process')->where($where)->update($data);
	}
	function DelFlowProcess($where){
		return Db::name('flow_process')->where($where)->delete();
	}
	function FindRun($id,$field='*'){
		return Db::name('run')->field($field)->find($id);
	}
	function EditRun($id,$data){
		return Db::name('run')->where('id',$id)->update($data);
	}
	function EditRunProcess($where,$data){
		return Db::name('run_process')->where($where)->update($data);
	}
    /**
     * 获取表字段信息
     *
     */
   function get_db_column_comment($table_name = '', $field = true, $table_schema = '')
    {
		$dbconfig = require ( BEASE_URL . '/config/common.php');
        $table_schema = empty($table_schema) ? $dbconfig['database'] : $table_schema;
        $table_name = $dbconfig['prefix'] . $table_name;
        $fieldName = $field === true ? 'allField' : $field;
        $cacheKeyName = 'db_' . $table_schema . '_' . $table_name . '_' . $fieldName;
        $param = [
            $table_name,
            $table_schema
        ];
        $columeName = '';
        if ($field !== true) {
            $param[] = $field;
            $columeName = "AND COLUMN_NAME = ?";
        }
        $res = Db::query("SELECT COLUMN_NAME as field,column_comment as comment FROM INFORMATION_SCHEMA.COLUMNS WHERE table_name = ? AND table_schema = ? $columeName", $param);
		$result = array();
        foreach ($res as $k => $value) {
            foreach ($value as $key => $v) {
                if ($value['comment'] != '') {
                    $result[$value['field']] = $value['comment'];
                }
            }
        }
        return count($result) == 1 ? reset($result) : $result;
    }
}