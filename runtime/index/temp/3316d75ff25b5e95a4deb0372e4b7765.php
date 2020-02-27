<?php /*a:2:{s:42:"D:\web\tpflow\app\index\view\wf\wfadd.html";i:1582799638;s:42:"D:\web\tpflow\app\index\view\pub\base.html";i:1582799638;}*/ ?>
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
<article class="page-container">
		<?php if(isset($info['id'])): ?>
			<form action="<?php echo url('wfedit'); ?>" method="post" name="form" id="form">
			<input type="hidden" name="id" value="<?php echo htmlentities($info['id']); ?>">
		<?php else: ?>
			<form action="<?php echo url('wfadd'); ?>" method="post" name="form" id="form">
		<?php endif; ?>
		<table class="table table-border table-bordered table-bg">
			<tr>
			<td style='width:75px'>流程名称</td>
			<td style='width:330px'><input type="text" class="input-text" value="<?php echo isset($info['flow_name']) ? htmlentities($info['flow_name']) : ''; ?>" name="flow_name"  datatype="*" ></td>
			
			</tr>
			<tr>
			<td>流程类型</td><td>
			<span class="select-box">
				<select name="type"  class="select"  datatype="*" >
					<?php if(is_array($type) || $type instanceof \think\Collection || $type instanceof \think\Paginator): $i = 0; $__LIST__ = $type;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$k): $mod = ($i % 2 );++$i;?>
					<option value="<?php echo htmlentities($key); ?>"><?php echo htmlentities($k); ?></option>
					<?php endforeach; endif; else: echo "" ;endif; ?>
				</select>
				</span>
			</td>
			</tr>
			<tr>
			<td style='width:75px'>排序值</td>
			<td style='width:330px'><input type="text" class="input-text" value="<?php echo isset($info['sort_order']) ? htmlentities($info['sort_order']) : ''; ?>" name="sort_order"  datatype="*" ></td>
			</tr>
			<tr>
			<tr>
			<td>流程描述</td><td>
			<textarea name='flow_desc'  datatype="*" style="width:100%;height:55px;"><?php echo isset($info['flow_desc']) ? htmlentities($info['flow_desc']) : ''; ?></textarea></td>
			
			</tr>
			<tr class='text-c'>
			<td colspan=2>
			<button  class="btn btn-primary radius" type="submit"><i class="Hui-iconfont">&#xe632;</i> 保存</button>
				<button  class="btn btn-default radius" type="button" onclick="layer_close()">&nbsp;&nbsp;取消&nbsp;&nbsp;</button></td>
			</tr>
			
		</table>
	</form>
</article>

<script type="text/javascript">
$(function(){
	$("[name='type']").find("[value='<?php echo isset($info['type']) ? htmlentities($info['type']) : '0'; ?>']").attr("selected",true);
	$("#form").Validform({
            tiptype:2,
            ajaxPost:true,
            showAllError:true,
            callback:function(ret){
                ajax_progress(ret);
            }
        });
});
</script>

</body>
</html>