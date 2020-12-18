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
namespace tpflow\lib;

use tpflow\adaptive\Process;
use tpflow\adaptive\User;

class lib
{
	public static function tpflow_status($status=0){
		$stv = [
			-1=>'<span class="label label-danger radius" >退回修改</span>',0=>'<span class="label radius">保存中</span>',1=>'<span class="label radius" >流程中</span>',2=>'<span class="label label-success radius" >审核通过</span>'
		];
		return $stv[$status] ?? 'ERR';
	}
	public static function tpflow_btn($wf_fid,$wf_type,$status,$url,$thisuser,$work)
	{
		switch ($status)
		{
		case 0:
		  return '<span class="btn  radius size-S" onclick=Tpflow.lopen(\'发起工作流\',"'.$url['url_star'].'",350,250)>发起工作流</span>';
		  break;
		case 1:
			$st = 0;
			$user_name ='';
			$flowinfo =  $work->workflowInfo($wf_fid,$wf_type,['uid'=>$thisuser['thisuid'],'role'=>$thisuser['thisrole']]);
			if($flowinfo!=-1){
				if(!isset($flowinfo['status'])){
					 return '<span class="btn btn-danger  radius size-S" onclick=javascript:alert("提示：当前流程故障，请联系管理员重置流程！")>Info:Flow Err</span>';
				}
					if($flowinfo['sing_st']==0){
						$user = explode(",", $flowinfo['status']['sponsor_ids']);
						$user_name =$flowinfo['status']['sponsor_text'];
						if($flowinfo['status']['auto_person']==3||$flowinfo['status']['auto_person']==4||$flowinfo['status']['auto_person']==6){
							if (in_array($thisuser['thisuid'], $user)) {
								$st = 1;
							}
						}
						if($flowinfo['status']['auto_person']==5){
							if (in_array($thisuser['thisrole'], $user)) {
								$st = 1;
							}
						}
					}else{
						if($flowinfo['sing_info']['uid']==$thisuser['thisuid']){
							  $st = 1;
						}else{
							  $user_name =$flowinfo['sing_info']['uid'];
						}
					}
				}else{
					 return '<span class="btn  radius size-S">无权限</span>';
				}	
				if($st == 1){
					 return '<span class="btn  radius size-S" onclick=Tpflow.lopen(\'审核单据信息：'.$wf_fid.'\',"'.$url['url'].'")>审核('.$user_name.')</span>';
					}else{
					 return '<span class="btn  radius size-S">无权限('.$user_name.')</span>';
				}
		case 100:
			return '<span class="button" onclick=Tpflow.lopen(\'代审\',"'.$url['url'].'&sup=1","850","650")>代审</span>';
		  break;
		  break;
		default:
		  return '';
		}
	}
	public static function tmp_add($url,$info,$type)
	{
		$js = self::commonjs(1);
		$view=<<<php
				<link rel="stylesheet" type="text/css" href="/static/work/workflow.4.0.css"/>
				<form action="{$url}" method="post" name="form" id="form">
				<input type="hidden" name="id" value="{$info['id']}">
				   <table class="table">
							<tr>
							<th style='width:75px'>流程名称</th>
							<td style='width:330px;text-align: left;'>
							<input type="text" class="input-text" value="{$info['flow_name']}" name="flow_name"  datatype="*" ></td></tr><tr>
							<th>流程类型</th><td style='width:330px;text-align: left;'>
							<span class="select-box"><select name="type"  class="select"  datatype="*" >{$type}</select></span>
							</td></tr>
							<tr><th style='width:75px'>排序值</th>
							<td style='width:330px;text-align: left;'><input type="text" class="input-text" value="{$info['sort_order']}" name="sort_order"  datatype="*" ></td></tr>
							<tr>
							<th>流程描述</th><td style='width:330px;text-align: left;'>
								<textarea name='flow_desc'  datatype="*" style="width:100%;height:55px;">{$info['flow_desc']}</textarea></td>
							</tr>
							<tr class='text-c' >
							<td colspan=2>
							<button  class="button" type="submit">&nbsp;&nbsp;保存&nbsp;&nbsp;</button>
								<button  class="button" type="button" onclick="Tpflow.lclose()">&nbsp;&nbsp;取消&nbsp;&nbsp;</button></td>
							</tr>
						</table>
					</form>
					{$js}
			<script type="text/javascript">
			$(function(){
				$("[name='type']").find("[value='{$info['type']}']").attr("selected",true);
			});
			</script>
php;
	return 	$view;	
	}
	public static function tmp_entrust($url,$info,$type,$user){
		$js = self::commonjs(1);
		 $view=<<<php
				<link rel="stylesheet" type="text/css" href="/static/work/workflow.4.0.css"/>
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
							<th>授权人</th><td style='width:330px;text-align: left;'>
							<select name="oldinfo"  class="select"  datatype="*" >{$user}</select>
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
							<button  class="button" type="submit">&nbsp;&nbsp;提交&nbsp;&nbsp;</button>&nbsp;&nbsp;<button  class="button" type="button" onclick="Tpflow.lclose()">&nbsp;&nbsp;取消&nbsp;&nbsp;</button></td>
							</tr><tr><td style='width:330px;text-align: left;' colspan=2>
								注：</td></tr>
						</table>
					</form>
					{$js}
			<script type="text/javascript">
			$(function(){
				$("[name='type']").find("[value='{$info['type']}']").attr("selected",true);
				$("[name='userinfo']").find("[value='{$info['userinfo']}']").attr("selected",true);
			});
			</script>
php;
		return 	$view;
	}
	public static function tmp_upload($url,$id){
		return <<<php
	<div class="page-container">
    <input type="hidden" id="callbackId" value="{$id}">
    <div><div id="drag" style='width:80px;margin-left:30px'>
                    <label for="file-input">
                        <img  width="120px"src="data:image/png;base64,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AAAAJXRFWHRkYXRlOmNyZWF0ZQAyMDIwLTAyLTI2VDA5OjExOjEwKzAwOjAwmvYnqAAAACV0RVh0ZGF0ZTptb2RpZnkAMjAxOS0wNC0yNVQwMjoxMDoyMCswMDowMAG1iHYAAAAgdEVYdHNvZnR3YXJlAGh0dHBzOi8vaW1hZ2VtYWdpY2sub3JnvM8dnQAAABh0RVh0VGh1bWI6OkRvY3VtZW50OjpQYWdlcwAxp/+7LwAAABh0RVh0VGh1bWI6OkltYWdlOjpIZWlnaHQAMTkyQF1xVQAAABd0RVh0VGh1bWI6OkltYWdlOjpXaWR0aAAzMDjhP6cxAAAAGXRFWHRUaHVtYjo6TWltZXR5cGUAaW1hZ2UvcG5nP7JWTgAAABd0RVh0VGh1bWI6Ok1UaW1lADE1NTYxNTgyMjDnCLouAAAAEXRFWHRUaHVtYjo6U2l6ZQA0ODUxQoxAmPUAAABadEVYdFRodW1iOjpVUkkAZmlsZTovLy9kYXRhL3d3d3Jvb3Qvd3d3LmVhc3lpY29uLm5ldC9jZG4taW1nLmVhc3lpY29uLmNuL2ZpbGVzLzEyMy8xMjMyOTc5LnBuZ6ul+WcAAAAASUVORK5CYII=">
                    </label>
                </div>
                <input type="file" accept="*/*" name="file[]" id="file-input" multiple class="input-file" style="display: none">
     </div>
</div>
<script type="text/javascript" src="/static/work/jquery-1.7.2.min.js" ></script>
<script type="text/javascript" src="/static/work/lib/layer/2.4/layer.js" ></script>
<script type="text/javascript" src="/static/work/workflow.4.0.js" ></script>
<script type="text/javascript" src="/static/work/lib/H5upload.js" ></script>
<script>
    $(function () {
        var callbackId = $("#callbackId").val();
        $("#file-input").tpUpload({
            url: '{$url}',
            data: {a: 'a'},
            drag: '',
            start: function () {
                layer_msg = layer.msg('正在上传中…', {time: 100000000});
            },
            progress: function (loaded, total, file) {
                $('.layui-layer-msg .layui-layer-content').html('已上传' + (loaded / total * 100).toFixed(2) + '%');
            },
            success: function (ret) {
                callback(callbackId,ret.msg[0],ret.data);
            },
            error: function (ret) {
                layer.alert(ret);
            },
            end: function () {
                layer.close(layer_msg);
            }
        });

    });
    /**
     * 数据回调
     * @param id
     * @param value
     */
    function callback(id,value,name) {
        if (window.parent.frames.length == 0){
            layer.alert('请在弹层中打开此页');
        } else {
            parent.document.getElementById(id).value = value;
			parent.$("#s"+id).remove();
			var data = '<br/><b id="s'+id+'">'+name+'</b>';
			parent.$('#b'+id).after(data);
			parent.$('#b'+id).html('上传成功！');
			parent.$('#b'+id).removeAttr('onclick');
            Tpflow.lclose();
        }
    }
</script>
php;
	}
	
	public static function tmp_user($url,$kid,$user){
		 return <<<php
		<link rel="stylesheet" type="text/css" href="/static/work/workflow.4.0.css"/>
<link rel="stylesheet" type="text/css" href="/static/work/multiselect2side.css" media="screen" />
<script type="text/javascript" src="/static/work/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="/static/work/multiselect2side.js" ></script>
<script type="text/javascript" src="/static/work/lib/layer/2.4/layer.js" ></script>
<script type="text/javascript" src="/static/work/workflow.4.0.js" ></script>
<article class="page-container">
<table class="table table-bordered table-bg">
			<tr><td><form method="post"><div class="text-l"><input type="text" id="key" style="width:150px" class="input-text"><a id="search" class="button">搜人员</a></div></form></td></tr>
			<tr><td><select name="dialog_searchable" id="dialog_searchable" multiple="multiple" style="display:none;">{$user}</select></td></tr><tr><td>
			<button class="btn btn-info" type="button" onclick='call_back()' id="dialog_confirm">确定</button>
			<button class="btn" type="button" id="dialog_close">取消</button></td></tr>
			</table>
</article>
<script type="text/javascript">
	function call_back(){
			var nameText = [];
            var idText = [];
			var html = "<table class='tables'><tr><td>序号</td><td>名称</td></tr>";
            if(!$('#dialog_searchable').val())
            {
               layer.msg('未选择');
				return false;
            }else
            {
              $('#dialog_searchable option').each(function(){
                if($(this).attr("selected"))
                {
                    nameText.push($(this).text());
                    idText.push($(this).val());
                }
                });
				for (x in nameText){
					html += '<tr><td>'+x+'</td><td>';
					html += nameText[x];
					html += '</td></tr>';
				}
					html += '</table>';
                var name = nameText.join(',');
				var ids = idText.join(',');
            }
		var index = parent.layer.getFrameIndex(window.name);
		parent.layer.msg('设置成功');
		parent.$('#{$kid}_ids').val(ids);
		parent.$('#{$kid}_text').val(name);
		parent.$('#{$kid}_html').html(html);
		parent.layer.close(index);
	}
    $(function(){
          $('#dialog_searchable').multiselect2side({
            selectedPosition: 'right',
            moveOptions: false,
            labelsx: '备选',
            labeldx: '已选',
            autoSort: true
            //,autoSortAvailable: true
        });
        //搜索用户
        $("#search").on("click",function(){
			var url = "{$url}";
			$.post(url,{"type":'user',"key":$('#key').val()},function(data){
				layer.msg(data.msg);
				var userdata = data.data;
				var optionList = [];
            for(var i=0;i<userdata.length;i++){
                optionList.push('<option value="');
                optionList.push(userdata[i].id);
                optionList.push('">');
                optionList.push(userdata[i].username);
                optionList.push('</option>');
            }
            $('#dialog_searchablems2side__sx').html(optionList.join(''));
			},'json');
        });
        $("#dialog_close").on("click",function(){
			var index = parent.layer.getFrameIndex(window.name);
            parent.layer.close(index);
        });
    });
	
</script>
php;
		
	}
	public static function tmp_role($url,$role){
		 return <<<php
		<link rel="stylesheet" type="text/css" href="/static/work/workflow.4.0.css"/>
<link rel="stylesheet" type="text/css" href="/static/work/multiselect2side.css" media="screen" />
<script type="text/javascript" src="/static/work/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="/static/work/multiselect2side.js" ></script>
<script type="text/javascript" src="/static/work/lib/layer/2.4/layer.js" ></script>
<script type="text/javascript" src="/static/work/workflow.4.0.js" ></script>
<article class="page-container">
<table class="table">
<tr><td><form method="post"><div class="text-l"><input type="text" id="key" style="width:150px" class="input-text"><a id="search" class="button">搜角色</a></div></form></td></tr>
<tr><td> <select name="dialog_searchable" id="dialog_searchable" multiple="multiple" style="display:none;">{$role}</select></td></tr>
<tr><td><button  type="button" onclick='call_back()' id="dialog_confirm">确定</button><button  type="button" id="dialog_close">取消</button></td></tr></table>
</article>
<script type="text/javascript">
	function call_back(){
			var nameText = [];
            var idText = [];
			var html = "<table class='tables'><tr><td>序号</td><td>名称</td></tr>";
            if(!$('#dialog_searchable').val())
            {
               layer.msg('未选择');
				return false;
            }else
            {
              $('#dialog_searchable option').each(function(){
                if($(this).attr("selected"))
                {
                    if($(this).val()=='all')//有全部，其它就不要了
                    {
                        nameText = [];
                        idText = [];
                        nameText.push($(this).text());
                        idText.push($(this).val());
                        return false;
                    }
                    nameText.push($(this).text());
                    idText.push($(this).val());
                }
                });
                var name = nameText.join(',');
				var ids = idText.join(',');
				for (x in nameText){
					html += '<tr><td>'+x+'</td><td>';
					html += nameText[x];
					html += '</td></tr>';
				}
				html += '</table>';
            }
		var index = parent.layer.getFrameIndex(window.name);
		parent.layer.msg('设置成功');
		parent.$('#auto_role_value').val(ids);
		parent.$('#auto_role_text').val(name);
		parent.$('#auto_role_html').html(html);
		parent.layer.close(index);
	}
    $(function(){
          $('#dialog_searchable').multiselect2side({
            selectedPosition: 'right',
            moveOptions: false,
            labelsx: '备选',
            labeldx: '已选',
            autoSort: true
        });
    $("#search").on("click",function(){
			var url = "{$url}";
			$.post(url,{"type":'role',"key":$('#key').val()},function(data){
				layer.msg(data.msg);
				var userdata = data.data;
				var optionList = [];
            for(var i=0;i<userdata.length;i++){
                optionList.push('<option value="');
                optionList.push(userdata[i].id);
                optionList.push('">');
                optionList.push(userdata[i].username);
                optionList.push('</option>');
            }
            $('#dialog_searchablems2side__sx').html(optionList.join(''));
			},'json');
        });
        $("#dialog_close").on("click",function(){
			var index = parent.layer.getFrameIndex(window.name);
            parent.layer.close(index);
        });
    });
	
</script>
php;
	}
	public static function tmp_wfjk($url,$data){
		$js = self::commonjs();
		 return <<<php
		<link rel="stylesheet" type="text/css" href="/static/work/workflow.4.0.css"/>
<div class="page-container">
	<table class="table">
		<tr class="text-c"><th>工作流编号</th><th >工作流类型</th><th >工作流名称</th><th >当前状态</th><th >业务办理人</th><th >接收时间</th><th >操作</th></tr>
		<tbody>
			{$data}
		</tbody>
	</table>
</div>{$js}
<script>
function end(id){
		layer.confirm('你确定终止此流程？[此操作无法恢复]',function(index){
			$.ajax({
				type: 'POST',
				url: '{$url}?id='+id,
				dataType: 'json',
				success: function(data){
					layer.msg('操作成功!',{icon:1,time:1000});
					setTimeout("location.reload()",1000);
				},
				error:function(data) {
					console.log(data.msg);
				},
			});		
		});
	}
</script>
</body>
</html>
php;
		
	}
	public static function tmp_wfstart($url,$info,$flow)
	{
		$js = self::commonjs(1);
		return <<<php
		<link rel="stylesheet" type="text/css" href="/static/work/workflow.4.0.css"/>
		<form action="{$url}" method="post" name="form" id="form">
		<input type='hidden' value="{$info['wf_fid']}" name='wf_fid'>
		<table class="table">
			<tr><td>选择工作流：</td><td style="text-align:left"><select name="wf_id"  class="select"  datatype="*" ><option value="">请选择工作流</option>{$flow}</select>
			</td></tr><tr>
			<td>审核意见：</td><td style="text-align:left"><input type="text" class="input-text" name="check_con"  datatype="*" >
			</td></tr>
			<tr><td colspan='2' class='text-c'><button  class="button" type="submit">&nbsp;&nbsp;保存&nbsp;&nbsp;</button>&nbsp;&nbsp;<button  class="button" type="button" onclick="Tpflow.lclose()">&nbsp;&nbsp;取消&nbsp;&nbsp;</button></td></tr>
		</table>
	</form>{$js}

</body>
</html>	
php;
	}
	public static function tmp_wfok($info,$flowinfo)
	{
		$js = self::commonjs();
		$sup = $_GET['sup'] ?? '';
	return <<<php
		<link rel="stylesheet" type="text/css" href="/static/work/workflow.4.0.css"/>
		<form action="{$info['tpflow_ok']}" method="post" name="form" id="wfform">
		<input id='upload' name='art' value='' type='hidden'>
		<input type="hidden" value="{$flowinfo['wf_mode']}" name="wf_mode" >
		<input type="hidden" value="{$flowinfo['nexid']}" name="npid" >
		<input type="hidden" value="{$flowinfo['run_id']}" name="run_id" id='run_id'>
		<input type="hidden" value="{$sup}" name="sup">
		<input type="hidden" value="{$flowinfo['run_process']}" name="run_process">
		<input type="hidden" value="{$flowinfo['flow_process']}" name="flow_process">
		<table class="table table-border table-bordered table-bg" style='width:98%'>
			<thead>
			<tr>
			<th style='width:98%' class='text-c'>单据审批</th>
			</tr>
			<tr>
			</thead>
			<td style='height:80px'>
				<table class="table table-border table-bordered table-bg">
				<tr>
				<td style='width:70px'>审批意见</td>
				<td><textarea name='check_con'  datatype="*" style="width:100%;height:55px;"></textarea> </td>
				</tr>
				<tr><td>下一步骤</td>
				<td style="text-align:left">
					{$flowinfo['npi']}
				</td>
				</tr>
				<tr>
				<td colspan=2 class='text-c'>
						<input id='submit_to_save' name='submit_to_save' value='ok' type='hidden'>
						<button  class="button" type="submit"> 提交同意</button>
						<a class="button" id='backbton' onclick='Tpflow.lclose()'>取消</a> 
				</td>
				</tr>
				</table>
			</td>
			
			</tr>
		</table>
</form>
</div>{$js}
<script type="text/javascript">
$(function(){
	$("#wfform").Validform({
            tiptype:function(msg,o,cssctl){
				if (o.type == 3){
					layer.msg(msg, {time: 800}); 
				}
			},
            ajaxPost:true,
            showAllError:true,
            callback:function(ret){
                  if (ret.code == 0) {
						layer.msg(ret.msg,{icon:1,time: 1500},function(){
							window.parent.parent.location.reload(); //关闭所有弹出层
							layer.closeAll();
						});          
					} else {
					   layer.alert(ret.msg, {title: "错误信息", icon: 2});
					}
            }
        });
});
</script>
</body>
</html>
php;
	}
	public static function tmp_wfback($info,$flowinfo)
	{
		$js = self::commonjs();
		$preprocess = Process::GetPreProcessInfo($flowinfo['run_process']);
		$op ='';
		foreach($preprocess as $k=>$v){
			   $op .='<option value="'.$k.'">'.$v.'</option>'; 
		}
		$sup = $_GET['sup'] ?? '';
	return <<<php
		<link rel="stylesheet" type="text/css" href="/static/work/workflow.4.0.css"/>
		<form action="{$info['tpflow_back']}" method="post" name="form" id="wfform">
		<input type="hidden" value="{$flowinfo['run_id']}" name="run_id" id='run_id'>
		<input type="hidden" value="{$sup}" name="sup">
		<input type="hidden" value="{$flowinfo['run_process']}" name="run_process">
		<table class="table table-border table-bordered table-bg" style='width:98%'>
			<thead>
			<tr>
			<th style='width:98%' class='text-c'>单据审批</th>
			</tr>
			<tr>
			</thead>
			<td style='height:80px'>
				<table class="table table-border table-bordered table-bg">
				<tr>
				<td style='width:70px'>回退意见</td>
				<td><textarea name='check_con'  datatype="*" style="width:100%;height:55px;"></textarea> </td>
				</tr>
				<tr><td>回退步骤</td>
				<td style="text-align:left"><select name="wf_backflow" id='backflow'  class="select"  datatype="*" onchange='find()'>
					<option value="">请选择回退步骤</option>{$op}</select>
				</td>
				</tr>
				<tr>
				<td colspan=2 class='text-c'>
						<input id='submit_to_save' name='submit_to_save' value='back' type='hidden'>
						<button  class="button" type="submit"> 提交回退</button>
						<a class="button" id='backbton' onclick='Tpflow.lclose()'>取消</a> 
				</td>
				</tr>
				</table>
			</td>
			
			</tr>
		</table>
</form>
</div>{$js}
<script type="text/javascript">
$(function(){
	$("#wfform").Validform({
            tiptype:function(msg,o,cssctl){
				if (o.type == 3){
					layer.msg(msg, {time: 800}); 
				}
			},
            ajaxPost:true,
            showAllError:true,
            callback:function(ret){
                  if (ret.code == 0) {
						layer.msg(ret.msg,{icon:1,time: 1500},function(){
							window.parent.parent.location.reload(); //关闭所有弹出层
							layer.closeAll();
						});          
					} else {
					   layer.alert(ret.msg, {title: "错误信息", icon: 2});
					}
            }
        });
});
</script>
</body>
</html>
php;
	}
	public static function tmp_wfdesc($id,$process_data,$urlApi)
	{
		return <<<php
	<link rel="stylesheet" type="text/css" href="/static/work/workflow.4.0.css"/>
 <body  style="height: 100%; overflow: hidden;margin: 0px; padding: 0px;"> 
  <div class="panel layout-panel panel-west split-west" style="left: 0px; width:145px; cursor: default;">
   <div class="panel-body"> <div class="panel" style="width: 140px;"><div class="panel-header">功能栏</div>
	  <div class="panel-body" style='text-align:center'>
		 欢迎使用流程设计器~<br/><br/>
		  <button class="btn btn-info" type="button" onclick='Tpflow.Api("save")'>保存设计</button><br/><br/>
		  <button class="btn btn-info" type="button" onclick='Tpflow.Api("add")'>新增步骤</button><br/><br/>
		  <button class="btn btn-info" type="button" onclick='Tpflow.Api("check")'>逻辑检查</button><br/><br/>
		  <button class="btn btn-info" type="button" onclick='Tpflow.Api("delAll")'>清空步骤</button><br/><br/>
		  <button class="btn btn-info" type="button" onclick='Tpflow.Api("Help")'>设计帮助</button><br/><br/>
		  <button class="btn btn-info" type="button" onclick='Tpflow.Api("Refresh")'>刷新设计</button><br/><br/>
      </div></div> 
   </div>
  </div> 
  <div class="panel layout-panel split-center" style="left:150px;  width:calc(100% - 645px); cursor: default;" > 
	<div  class="panel-body">
     <div class="panel"><div class="panel-header">流程设计栏</div>
	  <div class="panel-body" style="width:100%; height: 800px;" id="flowdesign_canvas"></div> 
     </div></div>
  </div> 
  <div class="panel layout-panel panel-west split-east split-west" style="left: calc(100% - 500px);  width:500px; cursor: default;">
    <div  class="panel-body"> 
     <div class="panel" >
      <div class="panel-header">属性控制栏</div>
	  <div class="panel-body" style='height: 800px;'>
		<iframe src="{$urlApi}?act=welcome" id="iframepage" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" onLoad="Tpflow.SetHeight()"></iframe>
	  </div></div> 
   </div>
  </div> 
 </body>
</html>
<script type="text/javascript" src="/static/work/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="/static/work/jquery-ui-1.9.2-min.js?" ></script>
<script type="text/javascript" src="/static/work/jsPlumb-1.3.16-all-min.js"></script>
<script type="text/javascript" src="/static/work/workflow.4.0.js" ></script>
<script type="text/javascript" src="/static/work/lib/layer/2.4/layer.js" ></script>
<script type="text/javascript">
var the_flow_id ='{$id}';
var Server_Url ="{$urlApi}";
var _this = $('#flowdesign_canvas');
$(function(){
	Tpflow.Init({$process_data});
});
</script>	
php;
	}
	public static function tmp_wfsign($info,$flowinfo,$sing)
	{
		$js = self::commonjs();
		$UserDb = User::GetUser();
		$op ='';
		foreach($UserDb as $k=>$v){
			   $op .='<option value="'.$v['id'].'">'.$v['username'].'</option>'; 
		}
		$sup = $_GET['sup'] ?? '';
	return <<<php
		<link rel="stylesheet" type="text/css" href="/static/work/workflow.4.0.css"/>
		<form action="{$info['tpflow_sign']}" method="post" name="form" id="wfform">
		<input type="hidden" value="{$flowinfo['run_id']}" name="run_id" id='run_id'>
		<input type="hidden" value="{$sup}" name="sup">
		<input type="hidden" value="{$flowinfo['run_process']}" name="run_process">
		<table class="table table-border table-bordered table-bg" style='width:98%'>
			<thead>
			<tr>
			<th style='width:98%' class='text-c'>单据审批</th>
			</tr>
			<tr>
			</thead>
			<td style='height:80px'>
				<table class="table table-border table-bordered table-bg">
				<tr>
				<td style='width:70px'>会签意见</td>
				<td><textarea name='check_con'  datatype="*" style="width:100%;height:55px;"></textarea> </td>
				</tr>
				<tr><td>会签接收人</td>
				<td style="text-align:left">
				<select name="wf_singflow" id='singflow'  class="select"  datatype="*" >
					<option value="">请选择会签人</option>{$op}</select>
				</td>
				</tr>
				<tr>
				<td colspan=2 class='text-c'>
						<input id='submit_to_save' name='submit_to_save' value='{$sing}' type='hidden'>
						<button  class="button" type="submit">会签</button>
						<a class="button" id='backbton' onclick='Tpflow.lclose()'>取消</a> 
				</td>
				</tr>
				</table>
			</td></tr>
		</table>
</form>
</div>{$js}
<script type="text/javascript">
$(function(){
	$("#wfform").Validform({
            tiptype:function(msg,o,cssctl){
				if (o.type == 3){
					layer.msg(msg, {time: 800}); 
				}
			},
            ajaxPost:true,
            showAllError:true,
            callback:function(ret){
                  if (ret.code == 0) {
						layer.msg(ret.msg,{icon:1,time: 1500},function(){
							window.parent.parent.location.reload(); //关闭所有弹出层
							layer.closeAll();
						});          
					} else {
					   layer.alert(ret.msg, {title: "错误信息", icon: 2});
					}
            }
        });
});
</script>
</body>
</html>
php;
}
public static function tmp_wfflow($process_data)
	{
		return <<<php
	<link rel="stylesheet" type="text/css" href="/static/work/workflow.4.0.css"/>
 <body  style="height: 100%; overflow: hidden;margin: 0px; padding: 0px;"> 
 
  <div class="panel layout-panel split-center" style="width:100%; cursor: default;" > 
	<div  class="panel-body">
	  <div class="panel-body" style="width:100%; height: 800px;" id="flowdesign_canvas"></div> 
     </div></div>
  </div> 
 </body>
</html>
<script type="text/javascript" src="/static/work/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="/static/work/jquery-ui-1.9.2-min.js?" ></script>
<script type="text/javascript" src="/static/work/jsPlumb-1.3.16-all-min.js"></script>
<script type="text/javascript" src="/static/work/workflow.4.0.js" ></script>
<script type="text/javascript" src="/static/work/lib/layer/2.4/layer.js" ></script>
<script type="text/javascript">
var _this = $('#flowdesign_canvas');
$(function(){
	Tpflow.show({$process_data});
});
</script>	
php;
	}
public static function tmp_index($url,$data,$html){
	$js = self::commonjs();
	return <<<php
<title>Tpflow V4.0 管理列表</title>
</head>
<link rel="stylesheet" type="text/css" href="/static/work/workflow.4.0.css"/>
<body>
<div class="page-container">
<div style='float: left;width:10%'>
	<a onclick="Tpflow.lopen('添加工作流','{$url}','550','400')" class="button ">添加</a> <a onclick="location.reload();" class="button ">刷新</a><hr/>
	<b style='font-size: 16px;'>工作流类别</b>
	<ul id="art">
	{$html}
	</ul>
</div>
<div style='float: left;width:90%'>
<table class="table" ><tr><th>ID</th><th>流程名称</th><th>流程类型</th><th>添加时间</th><th>状态</th><th>操作</th></tr>
	{$data}
</table>
</div>
</div>{$js}
</body>
</html>
php;
}
public static function tmp_wfgl($url,$data){
	$js = self::commonjs();
	return <<<php
<title>Tpflow V4.0 管理列表</title>
</head>
<link rel="stylesheet" type="text/css" href="/static/work/workflow.4.0.css"/>
<body>
<div class="page-container">
<div style='float: left;width:6%'>
	<a onclick="Tpflow.lopen('添加委托授权','{$url}','750','400')" class="button ">委托代理</a> <hr/>
	<a onclick="location.reload();" class="button ">刷新页面</a>

</div>
<div style='float: left;width:90%'>
<table class="table" ><tr><th>ID</th><th>授权名称</th> <th>委托类型</th><th>授权关系</th><th>起止时间</th><th>委托备注</th><th>操作</th></tr>
	{$data}
</table>
</div>
</div>{$js}
</body>
</html>
php;
}
public static function tmp_check($info,$flowinfo){
	$js = self::commonjs();
$url = url(unit::gconfig('int_url').'/'.$info['wf_type'].'/'.$flowinfo['status']['wf_action'],['id'=>$info['wf_fid']]);
	if($flowinfo['sing_st']==0){
		$html ='<a class="button" onclick=Tpflow.lopen("提交工作流","'.$info['tpflow_ok'].'",500,300) style="background-color: #19be6b">√ 同意</a> ';
		if($flowinfo['status']['is_back']!=2){
			$html .= '<a class="button"  onclick=Tpflow.lopen("工作流回退","'.$info['tpflow_back'].'",500,300) style="background-color: #c9302c;">↺ 驳回</a> ';
		}
		if($flowinfo['status']['is_sing']!=2){
			$html .= '<a class="button" onclick=Tpflow.lopen("工作流会签","'.$info['tpflow_sign'].'&ssing=sing",500,300) style="background-color: #f37b1d;">⇅ 会签</a>';
		}
	}else{
		$html ='<a class="button" onclick=Tpflow.sing_post("sok")>↷ 会签提交</a> <a class="button" onclick=Tpflow.sing_post("sback")>↶ 会签回退</a> <a class="button" onclick=Tpflow.lopen("工作流会签","'.$info['tpflow_sign'].'&ssing=ssing",500,300)>⇅ 再会签</a>';
	}
	$html .=' <a class="button" onclick=Tpflow.lopen("审批历史","",180,180)>✤ 审批历史</a> <a class="button" onclick=Tpflow.lopen("流程图","'.$info['tpflow_flow'].'")>≋ 流程图</a> ';
	return <<<php
<link rel="stylesheet" type="text/css" href="/static/work/workflow.4.0.css"/>
<div class="page-container" style='width:100%;padding: 0px;'>
<div class='TpflowController'>
{$html}
</div>
<div class='TpflowForm' >
	<div class='TpflowHead'>单据信息</div>
	<div style='width:100%;overflow-y:scroll; height:100%;'>
		<iframe src="{$url}" id="iframepage" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" onLoad="Tpflow.SetHeight()"></iframe>
	</div>
		
</div>
{$js}

</body>
</html>
php;
}

public static function tmp_wfatt($info,$flowinfo){
	$js = self::commonjs();
$url = url(unit::gconfig('int_url').'/'.$info['wf_type'].'/'.$flowinfo['status']['wf_action'],['id'=>$info['wf_fid']]);
	if($flowinfo['sing_st']==0){
		$html ='<a class="button" onclick=Tpflow.lopen("提交工作流","'.$info['tpflow_ok'].'",500,300) style="background-color: #19be6b">√ 同意</a> ';
		if($flowinfo['status']['is_back']!=2){
			$html .= '<a class="button"  onclick=Tpflow.lopen("工作流回退","'.$info['tpflow_back'].'",500,300) style="background-color: #c9302c;">↺ 驳回</a> ';
		}
		if($flowinfo['status']['is_sing']!=2){
			$html .= '<a class="button" onclick=Tpflow.lopen("工作流会签","'.$info['tpflow_sign'].'&ssing=sing",500,300) style="background-color: #f37b1d;">⇅ 会签</a>';
		}
	}else{
		$html ='<a class="button" onclick=Tpflow.sing_post("sok")>↷ 会签提交</a> <a class="button" onclick=Tpflow.sing_post("sback")>↶ 会签回退</a> <a class="button" onclick=Tpflow.lopen("工作流会签","'.$info['tpflow_sign'].'&ssing=ssing",500,300)>⇅ 再会签</a>';
	}
	$html .=' <a class="button" onclick=Tpflow.lopen("审批历史","",180,180)>✤ 审批历史</a> <a class="button" onclick=Tpflow.lopen("流程图","'.$info['tpflow_flow'].'")>≋ 流程图</a> ';
	return <<<php

	
	

</body>
</html>
php;
}
static function commonjs($form = 0){
	if($form==0){
		$js ='';
		}else{
		$js ='<script type="text/javascript">
$(function(){
	$("#form").Validform({
            tiptype:function(msg,o,cssctl){
				if (o.type == 3){
					layer.msg(msg, {time: 800}); 
				}
			},
            ajaxPost:true,
            showAllError:true,
            callback:function(ret){
                Tpflow.common_return(ret);
            }
        });
});
</script>';
	}
	return '<script type="text/javascript" src="/static/work/jquery-1.7.2.min.js" ></script><script type="text/javascript" src="/static/work/lib/layer/2.4/layer.js" ></script><script type="text/javascript" src="/static/work/workflow.4.0.js" ></script><script type="text/javascript" src="/static/work/lib/Validform/5.3.2/Validform.min.js" ></script>'.$js;	
}
	
}