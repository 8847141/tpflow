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
namespace tpflow\custom\target;

Interface BillTarget{
    public function getbill($bill_table,$bill_id);
    public function getbillvalue($bill_table,$bill_id,$bill_field);
    public function updatebill($bill_table,$bill_id,$updata);
}
