<?php
/**
*+------------------
* Tpflow 类库文件，公共函数
*+------------------
* Copyright (c) 2006~2018 http://cojz8.cn All rights reserved.
*+------------------
* Author: guoguo(1838188896@qq.com)
*+------------------ 
*/
namespace tpflow\lib;

class lib
{
	function tpflow_btn()
	{
		
		
		
		
	}
	function tmp_add($url,$info,$type)
	{
		$view=<<<php
				<link rel="stylesheet" type="text/css" href="/static/work/workflow-common.css"/>
				<form action="{$url}" method="post" name="form" id="form">
				<input type="hidden" name="id" value="{$info['id']}">
				   <table class="table">
							<tr>
							<th style='width:75px'>流程名称</th>
							<td style='width:330px;text-align: left;'>
							<input type="text" class="input-text" value="{$info['flow_name']}" name="flow_name"  datatype="*" ></td>
							
							</tr>
							<tr>
							<th>流程类型</th><td style='width:330px;text-align: left;'>
							<span class="select-box">
								<select name="type"  class="select"  datatype="*" >
								{$type}
								</select>
								</span>
							</td>
							</tr>
							<tr>
							<th style='width:75px'>排序值</th>
							<td style='width:330px;text-align: left;'><input type="text" class="input-text" value="{$info['sort_order']}" name="sort_order"  datatype="*" ></td>
							</tr>
							<tr>
							<tr>
							<th>流程描述</th><td style='width:330px;text-align: left;'>
								<textarea name='flow_desc'  datatype="*" style="width:100%;height:55px;">{$info['flow_desc']}</textarea></td>
							</tr>
							<tr class='text-c' >
							<td colspan=2>
							<button  class="button" type="submit">&nbsp;&nbsp;保存&nbsp;&nbsp;</button>
								<button  class="button" type="button" onclick="layer_close()">&nbsp;&nbsp;取消&nbsp;&nbsp;</button></td>
							</tr>
						</table>
					</form>
			<script type="text/javascript" src="/static/work/jquery-1.7.2.min.js" ></script>
			<script type="text/javascript" src="/static/work/lib/layer/2.4/layer.js" ></script>
			<script type="text/javascript" src="/static/work/workflow-common.3.0.js" ></script>
			<script type="text/javascript" src="/static/work/lib/Validform/5.3.2/Validform.min.js" ></script>
			<script type="text/javascript">
			$(function(){
				$("[name='type']").find("[value='{$info['type']}']").attr("selected",true);
				$("#form").Validform({
						 tiptype:function(msg,o,cssctl){
								if (o.type == 3){
									layer.msg(msg, {time: 800}); 
								}
						},
						ajaxPost:true,
						showAllError:true,
						callback:function(ret){
							ajax_progress(ret);
						}
					});
			});
			</script>
php;
	return 	$view;	
	}
	function tmp_entrust($url,$info,$type,$user){
		 $view=<<<php
				<link rel="stylesheet" type="text/css" href="/static/work/workflow-common.css"/>
				<form action="{$url}" method="post" name="form" id="form">
				<input type="hidden" name="id" value="{$info['id']}">
				   <table class="table">
							<tr>
							<th style='width:75px'>委托标题</th>
							<td style='width:330px;text-align: left;'>
								<input type="text" class="input-text" name="entrust_title"  datatype="*" value="{$info['entrust_title']}"></td>
							</tr><tr>
							<th>步骤授权</th><td style='width:330px;text-align: left;'>
							<select name="type"  class="select"  datatype="*" >
								<option value="0@0">不指定全局授权</option>'; 
								{$type}</select>
							</td></tr>
							<tr>
							<th>被授权人</th><td style='width:330px;text-align: left;'>
							<select name="userinfo"  class="select"  datatype="*" >{$user}</select>
							</td></tr>
							<tr><th>起止时间</th><td style='width:330px;text-align: left;'>
								<input name='entrust_stime' value="{$info['entrust_stime']}" datatype="*" type="datetime-local"/> ~ <input value="{$info['entrust_etime']}" name='entrust_etime' datatype="*" type="datetime-local"/></td>
							</tr><tr>
							<th>委托备注</th><td style='width:330px;text-align: left;'><textarea name='entrust_con'  datatype="*" style="width:100%;height:55px;">{$info['entrust_con']}</textarea></td></tr>
							<tr class='text-c' >
							<td colspan=2>
							<button  class="button" type="submit">&nbsp;&nbsp;提交&nbsp;&nbsp;</button>&nbsp;&nbsp;<button  class="button" type="button" onclick="layer_close()">&nbsp;&nbsp;取消&nbsp;&nbsp;</button></td>
							</tr><tr><td style='width:330px;text-align: left;' colspan=2>
								注：</td></tr>
						</table>
					</form>
			<script type="text/javascript" src="/static/work/jquery-1.7.2.min.js" ></script>
			<script type="text/javascript" src="/static/work/lib/layer/2.4/layer.js" ></script>
			<script type="text/javascript" src="/static/work/workflow-common.3.0.js" ></script>
			<script type="text/javascript" src="/static/work/lib/Validform/5.3.2/Validform.min.js" ></script>
			<script type="text/javascript">
			$(function(){
				$("[name='type']").find("[value='{$info['type']}']").attr("selected",true);
				$("[name='userinfo']").find("[value='{$info['userinfo']}']").attr("selected",true);
				$("#form").Validform({
						 tiptype:function(msg,o,cssctl){
								if (o.type == 3){
									layer.msg(msg, {time: 800}); 
								}
						},
						ajaxPost:true,
						showAllError:true,
						callback:function(ret){
							ajax_progress(ret);
						}
					});
			});
			</script>
php;
		return 	$view;
	}
}