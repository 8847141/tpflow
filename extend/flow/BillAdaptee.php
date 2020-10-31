<?php
namespace flow;
/**
*+------------------
* Tpflow 单据适配类
*+------------------
* Copyright (c) 2006~2018 http://cojz8.cn All rights reserved.
*+------------------
* Author: guoguo(1838188896@qq.com)
*+------------------
*/
use tpflow\inheritance\InterfaceBill;

class BillAdaptee implements InterfaceBill
{
	
	public  function getbill($bill_table,$bill_id){
		return 111;
	}
    public function getbillvalue($bill_table,$bill_id,$bill_field){
		$result = Db::name($bill_table)->where('id',$bill_id)->value($bill_field);
		 if(!$result){
            return  false;
        }
        return $result;
	}
    public function updatebill($bill_table,$bill_id,$updata){
		return 3;
	}
	
	
}