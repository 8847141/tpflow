<?php
/**
 *+------------------
 * Tpflow 调用接口类
 *+------------------
 * Copyright (c) 2006~2018 http://cojz8.cn All rights reserved.
 *+------------------
 * Author: guoguo(1838188896@qq.com)
 *+------------------
 */
namespace tpflow\adaptive;

use tpflow\inheritance\InterfaceBill;
use tpflow\lib\unit;

Class Bill implements InterfaceBill {
    
	protected $mode ; 
    public function  __construct($type='Bill'){
		if(unit::gconfig('wf_bill_mode')==1){
			$className = '\\tpflow\\custom\\Adaptee'.$type;
		}else{
			$className = unit::gconfig('wf_bill_namespace').$type;
		}
		$this->mode = new $className();
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
	public function checkbill($bill_table,$bill_id,$where)
		return $this->mode->checkbill($bill_table,$bill_id,$where);
	}
   
}