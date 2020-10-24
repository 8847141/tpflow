<?php
/**
*+------------------
* Tpflow 公共类，模板文件
*+------------------
* Copyright (c) 2006~2018 http://cojz8.cn All rights reserved.
*+------------------
* Author: guoguo(1838188896@qq.com)
*+------------------ 
*/
namespace tpflow;

/**
 * 根据键值加载全局配置文件
 *
 * @param  $key 键值
 */
function gconfig($key) {
	$ret = require ( BEASE_URL . '/config/common.php');
	return $ret[$key] ?? '';
}
/**
 * 消息返回统一处理
 *
 * @param  $msg  返回消息
 * @param  $code 返回代码 0 成功，1操作失败
 * @param  $data 返回数据
 */
function msg_return($msg = "操作成功！", $code = 0,$data = [])
{
	return json(["code" => $code, "msg" => $msg, "data" => $data]);
}

