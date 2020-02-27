<?php
// 应用公共文件
/**
 * ajax数据返回，规范格式
 */
 use think\facade\Db;
function msg_return($msg = "操作成功！", $code = 0,$data = [],$redirect = 'parent',$alert = '', $close = false, $url = '')
{
    $ret = ["code" => $code, "msg" => $msg, "data" => $data];
	$extend['opt'] = [
        'alert'    => $alert,
        'close'    => $close,
        'redirect' => $redirect,
        'url'      => $url,
    ];
    $ret = array_merge($ret, $extend);
    return json($ret);
}
function get_commonval($table,$id,$val)
{
	return Db::name($table)->where('id',$id)->value($val);
}