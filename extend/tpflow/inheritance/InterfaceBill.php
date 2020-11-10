<?php
/**
 *+------------------
 * Tpflow 单据接口
 *+------------------
 * Copyright (c) 2006~2018 http://cojz8.cn All rights reserved.
 *+------------------
 * Author: guoguo(1838188896@qq.com)
 *+------------------
 */
namespace tpflow\inheritance;

Interface InterfaceBill{
	/**
	 * 定义获取单据详细信息
	 * @param $bill_table 表名称
	 * @param $bill_id id
	 */
    public function getbill($bill_table,$bill_id);
	/**
	 * 定义获取单据单个字段值
	 * @param $bill_table 表名称
	 * @param $bill_id id
	 * @param $bill_field 查询参数
	 */
    public function getbillvalue($bill_table,$bill_id,$bill_field);
	/**
	 * 更新单据信息
	 * @param $bill_table 表名称
	 * @param $bill_id id
	 * @param $updata 更新数据
	 */
    public function updatebill($bill_table,$bill_id,$updata);
	/**
	 * 判断单据信息
	 * @param $bill_table 表名称
	 * @param $bill_id id
	 * @param $where 判断条件
	 */
	public function checkbill($bill_table,$bill_id,$where);
}