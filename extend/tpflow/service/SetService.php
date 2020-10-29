<?php
/**
*+------------------
* Tpflow 工作流任务服务
*+------------------ 
* Copyright (c) 2006~2018 http://cojz8.cn All rights reserved.
*+------------------
* Author: guoguo(1838188896@qq.com)
*+------------------
*/
namespace tpflow\service;

class SetService{
	private static $_instance;
	
	private $wfuid = "";//流程id
	private $etuid = "";//单据id
	//private标记的构造方法
	private function __construct(){
		
	}
	//创建__clone方法防止对象被复制克隆
	public function __clone(){
		echo 'Clone is not allow!';
	}
	 
	//单例方法,用于访问实例的公共的静态方法
	public static function getInstance(){
		if(!(self::$_instance instanceof self)){
			self::$_instance = new self;
		}
		return self::$_instance;
	}
	//清空数据
	public function clear(){
		$this->wfuid = "";//流程id
		$this->etuid = "";//单据id
	
		
	}
	/**
	 * @return unknown
	 */
	public function getEtuid() {
		return $this->etuid;
	}
	
	/**
	 * @param unknown_type $etuid
	 */
	public function setEtuid($etuid) {
		$this->etuid = $etuid;
	}
	/**
	 * @return unknown
	 */
	public function getWfuid() {
		return $this->wfuid;
	}
	
	/**
	 * @param unknown_type $wfuid
	 */
	public function setWfuid($wfuid) {
		$this->wfuid = $wfuid;
	}

}