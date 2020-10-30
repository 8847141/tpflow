<?php
/**
 *+------------------
 * Tpflow 模板驱动类
 *+------------------
 * Copyright (c) 2006~2018 http://cojz8.cn All rights reserved.
 *+------------------
 * Author: guoguo(1838188896@qq.com)
 *+------------------
 */
namespace tpflow\custom;

use think\custom\target\BillTarget;

Class Bill implements BillTarget {
    
	protected $mode ; 
    public function  __construct($type){
        $type = $type."Adapter" ;
        $this->mode = new $type ;
    }
	public function getbill($bill_table,$bill_id){
		return $this->mode->getbill($bill_table,$bill_id);
	}
    public function getbillvalue($bill_table,$bill_id,$bill_field){
		return $this->mode->getbillvalue($bill_table,$bill_id,$bill_field);
	}
    public function updatebill($bill_table,$bill_id,$updata){
		return $this->mode->updatebill($bill_table,$bill_id,$updata);
	}
   
}