<?php /*a:2:{s:62:"C:\Users\Administrator\web\tpflow\app\index\view\wf\wfatt.html";i:1582093291;s:62:"C:\Users\Administrator\web\tpflow\app\index\view\pub\base.html";i:1581909452;}*/ ?>
<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<meta name="renderer" content="webkit|ie-comp|ie-stand">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
<meta http-equiv="Cache-Control" content="no-siteapp" />
<link rel="Bookmark" href="/favicon.ico" >
<link rel="Shortcut Icon" href="/favicon.ico" />
<!--[if lt IE 9]>
<script type="text/javascript" src="lib/html5shiv.js"></script>
<script type="text/javascript" src="lib/respond.min.js"></script>
<![endif]-->
<link rel="stylesheet" type="text/css" href="/static/h-ui/css/H-ui.min.css" />
<link rel="stylesheet" type="text/css" href="/static/h-ui.admin/css/H-ui.admin.css" />
<link rel="stylesheet" type="text/css" href="/static/lib/Hui-iconfont/1.0.8/iconfont.css" />
<link rel="stylesheet" type="text/css" href="/static/h-ui.admin/skin/blue/skin.css" id="blue" />
<link rel="stylesheet" type="text/css" href="/static/h-ui.admin/css/style.css" />
<link rel="stylesheet" type="text/css" href="/static/h-ui.admin/common.css" />
<!--[if IE 6]>
<script type="text/javascript" src="lib/DD_belatedPNG_0.0.8a-min.js" ></script>
<script>DD_belatedPNG.fix('*');</script>
<![endif]-->
<script type="text/javascript" src="/static/lib/jquery/1.9.1/jquery.min.js"></script> 
<script type="text/javascript" src="/static/lib/layer/2.4/layer.js"></script>
<script type="text/javascript" src="/static/h-ui/js/H-ui.min.js"></script>
<script type="text/javascript" src="/static/h-ui.admin/js/H-ui.admin.js"></script>
<script type="text/javascript" src="/static/lib/Validform/5.3.2/Validform.min.js"></script>
<script type="text/javascript" src="/static/h-ui.admin/common.js"></script>
<script type="text/javascript" src="/static/lib/laydate5.0.9/laydate.js"></script>
<title>Tpflow</title>
</head>
<body>
<link rel="stylesheet" type="text/css" href="/static/work/workflow.3.0.css"/>
<link rel="stylesheet" type="text/css" href="/static/work/multiselect2side.css"/>
<form  class="form-horizontal" action="<?php echo url('save_attribute'); ?>" method="post" name="form" id="form">
<style type="text/css">
       #box{
           height: auto;
           width: auto;
           border: 1px solid #ccc;
           
       }
       ul{
           height: 30px;
           width: 600px;
           padding: 0;
           margin: 0;
       }
       li{
           display: block;
           text-align: center;
           width: 80px;
           float: left;
           list-style: none;
           cursor: pointer;
           height: 30px;
           line-height: 30px;
       }
       .choice{
               background: #409EFF;
               color: #fff;
       }
       .tab-item{
           display: none;
       }
       .show{
           display: block;
       }
   </style>
</head>
<body>
   <ul>
       <li tabid="1" class="choice">节点信息</li>
       <li tabid="2">节点属性</li>
       <li tabid="3">节点人员</li>
	   <li tabid="4">节点转出</li>
	   <li tabid="5">节点事务</li>
   </ul>
   <div id="box">
       <div class="tab-item show">
	   <input type="hidden" name="flow_id" value="<?php echo htmlentities($one['flow_id']); ?>"/>
	<input type="hidden" name="process_id" value="<?php echo htmlentities($one['id']); ?>"/>
		<table class="tables">
			<tr><td>节点ID</td><td><?php echo htmlentities($one['id']); ?></td></tr>
			<tr><td>步骤名称</td><td><input type="text" class="smalls" name="process_name" value="<?php echo htmlentities($one['process_name']); ?>"></td></tr>
			<tr><td>步骤尺寸</td><td><input type="text" class="smalls" name="style_width" value="<?php echo htmlentities($one['style']['width']); ?>" style='width:60px'> X <input type="text" class="smalls" name="style_height" value="<?php echo htmlentities($one['style']['height']); ?>" readonly style='width:60px'></td></tr>
		</table>
	   
	   </div>
       <div class="tab-item">
	   <table class="tables">
	   <tr><td>步骤类型</td><td><input type="radio" name="process_type" value="is_step" <?php if($one['process_type'] == 'is_step'): ?>checked="checked"<?php endif; ?>>正常步骤
                <input type="radio" name="process_type" value="is_one" <?php if($one['process_type'] == 'is_one'): ?>checked="checked"<?php endif; ?>>第一步</td></tr>
		<tr><td>调用方法</td><td><input type="text" class="smalls" name="wf_action"  value="<?php echo isset($one['wf_action']) ? htmlentities($one['wf_action']) : 'view'; ?>"></td></tr>	
<tr><td>会签方式</td><td><select name="is_sing" >
              <option value="1" <?php if($one['is_sing'] == 1): ?>selected="selected"<?php endif; ?>>允许会签</option>
              <option value="2" <?php if($one['is_sing'] == 2): ?>selected="selected"<?php endif; ?>>禁止会签</option>
            </select></td></tr>	
<tr><td>回退方式</td><td><select name="is_back" >
              <option value="1" <?php if($one['is_back'] == 1): ?>selected="selected"<?php endif; ?>>不允许</option>
              <option value="2" <?php if($one['is_back'] == 2): ?>selected="selected"<?php endif; ?>>允许回退</option>
            </select></td></tr>			
		
	   </table></div>
       <div class="tab-item"> <table class="tables">
	   <tr><td>办理人员</td><td colspan='3'><select name="auto_person" id="auto_person_id" datatype="*" nullmsg="请选择办理人员或者角色！">
                <option value="">请选择</option>
				 <?php if($one['process_type'] != 'is_one'): ?><option value="3" <?php if($one['auto_person'] == 3): ?>selected="selected"<?php endif; ?>>自由选择</option><?php endif; ?>
				 <option value="4" <?php if($one['auto_person'] == 4): ?>selected="selected"<?php endif; ?>>指定人员</option>
                <option value="5" <?php if($one['auto_person'] == 5): ?>selected="selected"<?php endif; ?>>指定角色</option>
				<option value="6" <?php if($one['auto_person'] == 6): ?>selected="selected"<?php endif; ?>>事务接受</option>
              </select></td></tr> 
			<tr id="auto_person_3" <?php if($one['auto_person'] != 3): ?>class="hide"<?php endif; ?>><td>自由选择</br>
			<a class="btn" onclick="layer_show('办理人','<?php echo url('super_user',['kid'=>'range_user']); ?>','350','500')">选择</a>
			</td><td> 
				<input type="hidden" name="range_user_ids" id="range_user_ids" value="<?php echo htmlentities($one['range_user_ids']); ?>">
                    <input class="input-xlarge" readonly="readonly" type="hidden" placeholder="选择办理人范围" name="range_user_text" id="range_user_text" value="<?php echo isset($one['range_user_text']) ? htmlentities($one['range_user_text']) : ''; ?>"> 
					
					<span id='range_user_html'>
					<?php if(count(explode(",",$one['range_user_text'])) >= 1): ?>
					<table class='tables'><tr><td>序号</td><td>名称</td></tr>
						<?php $_result=explode(",",$one['range_user_text']);if(is_array($_result) || $_result instanceof \think\Collection || $_result instanceof \think\Paginator): $i = 0; $__LIST__ = $_result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
							<tr><td><?php echo htmlentities($key); ?></td><td><?php echo htmlentities($vo); ?></td></tr>
						<?php endforeach; endif; else: echo "" ;endif; ?>
						</table><?php else: ?>
						<h4>Tip:请按右侧选择添加办理人员</h4>
						<?php endif; ?>
					</span>
					
					</td>	
			</tr>
			<tr id="auto_person_4" <?php if($one['auto_person'] != 4): ?>class="hide"<?php endif; ?>><td>指定人员
			</br/><a class="btn" onclick="layer_show('办理人','<?php echo url('super_user',['kid'=>'auto_sponsor']); ?>','350','500')">选择</a></td><td> 
			
			<input type="hidden" name="auto_sponsor_ids" id="auto_sponsor_ids" value="<?php echo htmlentities($one['auto_sponsor_ids']); ?>">
             <input class="input-xlarge" readonly="readonly" type="hidden" placeholder="指定办理人" name="auto_sponsor_text" id="auto_sponsor_text" value="<?php echo isset($one['auto_sponsor_text']) ? htmlentities($one['auto_sponsor_text']) : ''; ?>"> 
				<span id='auto_sponsor_html'>
				<?php if(count(explode(",",$one['auto_sponsor_text'])) >= 1): ?>
					<table class='tables'><tr><td>序号</td><td>名称</td></tr>
						<?php $_result=explode(",",$one['auto_sponsor_text']);if(is_array($_result) || $_result instanceof \think\Collection || $_result instanceof \think\Paginator): $i = 0; $__LIST__ = $_result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
							<tr><td><?php echo htmlentities($key); ?></td><td><?php echo htmlentities($vo); ?></td></tr>
						<?php endforeach; endif; else: echo "" ;endif; ?>
						</table>	<?php else: ?>
						<h4>Tip:请按右侧选择添加办理人员</h4><?php endif; ?>
					</span>	
					</td>	
			</tr>
			<tr id="auto_person_5" <?php if($one['auto_person'] != 5): ?>class="hide"<?php endif; ?>><td>指定角色<br/><a class="btn" onclick="layer_show('办理人','<?php echo url('super_role'); ?>','350','500')">选择</a></td><td> 
			<input type="hidden" name="auto_role_ids" id="auto_role_value" value="<?php echo htmlentities($one['auto_role_ids']); ?>" >
			
			<span id='auto_role_html'>
			<?php if(count(explode(",",$one['auto_role_text'])) >= 1): ?>
					<table class='tables'><tr><td>序号</td><td>名称</td></tr>
						<?php $_result=explode(",",$one['auto_role_text']);if(is_array($_result) || $_result instanceof \think\Collection || $_result instanceof \think\Paginator): $i = 0; $__LIST__ = $_result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
							<tr><td><?php echo htmlentities($key); ?></td><td><?php echo htmlentities($vo); ?></td></tr>
						<?php endforeach; endif; else: echo "" ;endif; ?>
						</table>
						<?php else: ?>
						<h4>Tip:请按右侧选择添加办理人员</h4>
						<?php endif; ?>
			</span>
				
            <input class="input-xlarge" readonly="readonly" type="hidden" placeholder="指定角色" name="auto_role_text" id="auto_role_text" value="<?php echo isset($one['auto_role_text']) ? htmlentities($one['auto_role_text']) : ''; ?>">
			</td>	
			</tr>
			<tr id="auto_person_6" <?php if($one['auto_person'] != 6): ?>class="hide"<?php endif; ?>><td>事务接受</td><td> 
				取业务表<select   class="smalls" name='work_text'>
              <option value="">选择字段</option>
			  <?php if(is_array($from) || $from instanceof \think\Collection || $from instanceof \think\Paginator): $i = 0; $__LIST__ = $from;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?>
			  <option value="<?php echo htmlentities($key); ?>" <?php if($key == $one["work_text"]): ?>selected<?php endif; ?>><?php echo htmlentities($v); ?></option>
			  <?php endforeach; endif; else: echo "" ;endif; ?>
            </select>的 
			<select name="work_ids"  nullmsg="人员">
				<option value="1" <?php if(1 == $one["work_ids"]): ?>selected<?php endif; ?>>制单人员</option>
			</select>
			</td>	
			</tr>
			
			
			
			</table>
	   </div>
	   <div class="tab-item">
	    <table class="tables">
				<tr><td>步骤模式</td><td  colspan='3'>
					<select name="wf_mode" id="wf_mode_id" datatype="*" nullmsg="请选择步骤模式">
					<option value="">请选择步骤模式</option>
					<?php if(count($one['process_to'])>1): ?>
					 <option value="1" <?php if($one['wf_mode'] == 1): ?>selected="selected"<?php endif; ?>>转出模式（符合执行）</option>
					 <option value="2" <?php if($one['wf_mode'] == 2): ?>selected="selected"<?php endif; ?>>同步模式（均需办理）</option>
					 <?php else: ?>
					 <option value="0" <?php if($one['wf_mode'] == 0): ?>selected="selected"<?php endif; ?>>单线模式（流程为直线型单一办理模式）</option>
					<?php endif; ?>
				  </select>
				</td></tr>	
<!--重新设计，带转出模式-->
<tr id='wf_mode_2' <?php if($one['wf_mode'] != 1): ?>class="hide"<?php endif; ?>>
<td colspan=4>
<table class="table" ><thead><tr><th style="width:30px;">步骤</th><th>转出条件设置</th></tr></thead><tbody>
<!--模板-->
<?php if(is_array($process_to_list) || $process_to_list instanceof \think\Collection || $process_to_list instanceof \think\Paginator): $i = 0; $__LIST__ = $process_to_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$k): $mod = ($i % 2 );++$i;if(in_array($k['id'],$one['process_to'])): ?>
<tr>    
<td style="width: 30px;"><?php echo htmlentities($k['process_name']); ?><?php echo htmlentities($k['id']); ?></td>
<td>
    <table class="table table-condensed">
    <tbody>
      <tr>
        <td>
            <select id="field_<?php echo htmlentities($k['id']); ?>" class="smalls">
              <option value="">选择字段</option>
			  <?php if(is_array($from) || $from instanceof \think\Collection || $from instanceof \think\Paginator): $i = 0; $__LIST__ = $from;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?>
			  <option value="<?php echo htmlentities($key); ?>"><?php echo htmlentities($v); ?></option>
			  <?php endforeach; endif; else: echo "" ;endif; ?>
            </select>
            <select id="condition_<?php echo htmlentities($k['id']); ?>" class="smalls" style="width: 60px;">
				<option value="=">=</option>
				<option value="&lt;&gt;"><></option>
				<option value="&gt;">></option>
				<option value="&lt;"><</option>
				<option value="&gt;=">>=</option>
				<option value="&lt;="><=</option>
				<option value="include">含</option>
				<option value="exclude">不含</option>
            </select>
            <input type="text" id="item_value_<?php echo htmlentities($k['id']); ?>" class="smalls" style="width: 40px;">
            <select id="relation_<?php echo htmlentities($k['id']); ?>" class="smalls" style="width: 40px;"><option value="AND">AND</option><option value="OR">OR</option>
            </select>
        </td>
        <td>
			<button type="button" class="wf_btn" onclick="fnAddLeftParenthesis('<?php echo htmlentities($k['id']); ?>')">（</button>
			<button type="button" class="wf_btn" onclick="fnAddRightParenthesis('<?php echo htmlentities($k['id']); ?>')">）</button>
			<button type="button" onclick="fnAddConditions('<?php echo htmlentities($k['id']); ?>')" class="wf_btn">新增</button>
        </td>
       </tr>
       <tr>
        <td>
            <select id="conList_<?php echo htmlentities($k['id']); ?>" multiple="" style="width: 100%;height: 80px;">
			<?php echo $k['condition']; ?>
			</select>
        </td>
        <td>
        <button type="button" onclick="fnDelCon('<?php echo htmlentities($k['id']); ?>')" class="wf_btn">删行</button>
        <button type="button" onclick="fnClearCon('<?php echo htmlentities($k['id']); ?>')" class="wf_btn">清空</button>
           <input name="process_in_set_<?php echo htmlentities($k['id']); ?>" id="process_in_set_<?php echo htmlentities($k['id']); ?>" type="hidden">
        </td>
      </tr>
     
    </tbody>
    </table>
</td>
</tr>
<?php endif; ?>
<?php endforeach; endif; else: echo "" ;endif; ?>
</table></td></tr></table>
	   </div>
   
  <div class="tab-item">
  <table class="tables">
		<tr><td width='160px'style="display:table-cell; vertical-align:middle">事务SQL
		<hr>
		单据ID：@from_id<br/>
		节点ID：@run_id<br/>
		提交意见：@check_con
		
		</td><td><textarea name='work_sql'  type="text/plain" style="width:100%;height:100px;"><?php echo isset($one['work_sql']) ? htmlentities($one['work_sql']) : ''; ?></textarea>
		Tip:UPDATE Table SET field1=value1 WHERE id=@run_id;
		</td></tr>		
		<tr><td style="display:table-cell; vertical-align:middle">事务MSG
		<hr>
		单据ID：@from_id<br/>
		节点ID：@run_id<br/>
		提交意见：@check_con
		</td><td><textarea name='work_msg'  type="text/plain" style="width:100%;height:100px;"><?php echo isset($one['work_msg']) ? htmlentities($one['work_msg']) : ''; ?></textarea>
		Tip:您好,您有需要审批的业务,业务编号为：@run_id;
		</td></tr>	
   </table>
   
   </div>  
   
   
   </div> 
   <table class="tables">
   <tr>
   <td style='text-align: center;'>
   <a onclick="layer_close()" class="btn" >取消</a>
   <button  class="btn btn-primary radius" type="submit"><i class="Hui-iconfont">&#xe632;</i> 保存</button>
</td></tr>	
    </table>
   
   <script type="text/javascript">
       $("li").click(function(){
           $(this).attr("class","choice")
           $(this).siblings().attr("class","")
           var itemId = $(this).attr("tabid")-1;
	
           $("#box").find("div:eq("+itemId+")").attr("class","show")
           $("#box").find("div:eq("+itemId+")").siblings().attr("class","tab-item")
       })
   </script>


    
<input type="hidden" name="process_condition" id="process_condition" value='<?php echo htmlentities($one['process_tos']); ?>'>

<div>

 
</div>
</form>
<script type="text/javascript" src="/static/work/jquery-1.7.2.min.js?"></script>
<script type="text/javascript" src="/static/work/jquery-ui-1.9.2-min.js?" ></script>
<script type="text/javascript" src="/static/work/multiselect2side.js?" ></script>
<script type="text/javascript" src="/static/work/workflow-att.3.0.js"></script>
<script type="text/javascript" src="/static/lib/Validform/5.3.2/Validform.min.js"></script>
<script type="text/javascript">
$(function(){
	$("#form").Validform({
            tiptype:1,
            ajaxPost:true,
            showAllError:true,
            callback:function(ret){
                ajax_progress(ret);
            }
        });
});
var wf_mode = "<?php echo isset($one['wf_mode'])?$one['wf_mode']:'0'; ?>";
if(wf_mode ==1){
	check_from();	
}
</script>
