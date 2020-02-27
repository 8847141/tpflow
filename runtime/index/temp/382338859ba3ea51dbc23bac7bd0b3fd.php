<?php /*a:2:{s:44:"D:\web\tpflow\app\index\view\wf\wfcheck.html";i:1582806563;s:42:"D:\web\tpflow\app\index\view\pub\base.html";i:1582799638;}*/ ?>
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
<link rel="stylesheet" href="/static/lib/multiple-select/multiple-select.css" />
<div class="page-container" style='width:98%'>
<form action="<?php echo url('do_check_save'); ?>" method="post" name="form" id="forms">
<input type="hidden" value="<?php echo htmlentities($info['wf_title']); ?>" name="wf_title">
<input type="hidden" value="<?php echo htmlentities($info['wf_fid']); ?>" name="wf_fid">
<input type="hidden" value="<?php echo htmlentities($info['wf_type']); ?>" name="wf_type">
<input type="hidden" value="<?php echo htmlentities($flowinfo['flow_id']); ?>" name="flow_id">
<input type="hidden" value="<?php echo htmlentities($flowinfo['flow_process']); ?>" name="flow_process">
<input type="hidden" value="<?php echo htmlentities($flowinfo['run_id']); ?>" name="run_id" id='run_id'>
<input type="hidden" value="<?php echo htmlentities($flowinfo['run_process']); ?>" name="run_process">
<?php if($flowinfo['status']['wf_mode'] != 2): ?>
<input type="hidden" value="<?php echo htmlentities($flowinfo['nexprocess']['id']); ?>" name="npid">
<?php else: ?>
<input type="hidden" value="<?php echo htmlentities($flowinfo['process']['process_to']); ?>" name="npid">
<?php endif; ?>
<input type="hidden" value="<?php echo htmlentities($flowinfo['wf_mode']); ?>" name="wf_mode">

<input type="hidden" value="<?php echo isset($_GET['sup']) ? htmlentities($_GET['sup']) : ''; ?>" name="sup">
		<table class="table table-border table-bordered table-bg" style='width:98%'>
			<thead>
			<tr>
			<th style='width:38%' class='text-c'>单据审批</th>
			<th style='width:59%' class='text-c'>审批记录</th>
			</tr>
			<tr>
			</thead>
			<td style='height:80px'>
				<table class="table table-border table-bordered table-bg">
				<tr>
				<th style='width:30px'>
				<?php if($flowinfo['sing_st'] == 0): ?>审批<?php else: ?>会签<?php endif; ?>意见</th>
				<th><textarea name='check_con'  datatype="*" style="width:100%;height:55px;"></textarea> </th>
				</tr>
				<tr id='nex_process'>
				<th style='width:30px' >下一步骤</th>
				<th>
				<?php if($flowinfo['wf_mode'] == 2): ?>[同步]<?php endif; if($flowinfo['status']['wf_mode'] != 2): if($flowinfo['nexprocess']['auto_person'] != 3): ?>
						<?php echo htmlentities($flowinfo['nexprocess']['process_name']); ?>(<?php echo htmlentities($flowinfo['nexprocess']['todo']); ?>)
					<?php else: ?>
						<span class="select-box">
						<select name="todo" id='todo'  class="select"  datatype="*" >
						<option value="">请指定办理人员</option>
						<?php if(is_array($flowinfo['nexprocess']['todo']['ids']) || $flowinfo['nexprocess']['todo']['ids'] instanceof \think\Collection || $flowinfo['nexprocess']['todo']['ids'] instanceof \think\Paginator): $i = 0; $__LIST__ = $flowinfo['nexprocess']['todo']['ids'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$todo): $mod = ($i % 2 );++$i;?>
						<option value="<?php echo htmlentities($todo); ?>*%*<?php echo htmlentities($flowinfo['nexprocess']['todo']['text'][$key]); ?>"><?php echo htmlentities($flowinfo['nexprocess']['todo']['text'][$key]); ?></option>
						<?php endforeach; endif; else: echo "" ;endif; ?>
						</select>
					<?php endif; else: ?>
					<!--同步模式-->
					<?php if(is_array($flowinfo['nexprocess']) || $flowinfo['nexprocess'] instanceof \think\Collection || $flowinfo['nexprocess'] instanceof \think\Paginator): $i = 0; $__LIST__ = $flowinfo['nexprocess'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?>
						<?php echo htmlentities($v['process_name']); ?>(<?php echo htmlentities($v['todo']); ?>)<br/>
					<?php endforeach; endif; else: echo "" ;endif; ?>
				<?php endif; ?>
				
				
				</th>
				</tr>
				<tr style='display:none' id='back_process'>
				<th style='width:30px'>回退步骤</th>
				<th>
					<span class="select-box">
					<select name="wf_backflow" id='backflow'  class="select"  datatype="*" onchange='find()'>
					<option value="">请选择回退步骤</option>
					<?php if(is_array($flowinfo['preprocess']) || $flowinfo['preprocess'] instanceof \think\Collection || $flowinfo['preprocess'] instanceof \think\Paginator): $i = 0; $__LIST__ = $flowinfo['preprocess'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$back): $mod = ($i % 2 );++$i;?>
					<option value="<?php echo htmlentities($key); ?>"><?php echo htmlentities($back); ?></option>
					<?php endforeach; endif; else: echo "" ;endif; ?>
					</select>
					<input type="hidden" value="" name="btodo" id='btodo'>
				</span>
				</th>
				</tr>
				<tr style='display:none' id='sing_process'>
				<th style='width:30px'>会签步骤</th>
				<th>
					<span class="select-box">
					<select name="wf_singflow" id='singflow'  class="select"  datatype="*" >
					<option value="">请选择会签人</option>
					<?php if(is_array($flowinfo['singuser']) || $flowinfo['singuser'] instanceof \think\Collection || $flowinfo['singuser'] instanceof \think\Paginator): $i = 0; $__LIST__ = $flowinfo['singuser'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$sing): $mod = ($i % 2 );++$i;?>
					<option value="<?php echo htmlentities($sing['id']); ?>"><?php echo htmlentities($sing['username']); ?></option>
					<?php endforeach; endif; else: echo "" ;endif; ?>
					</select>
				
				</th>
				</tr>
				<tr>
				<td colspan=2 class='text-c'>
				<input id='submit_to_save' name='submit_to_save' value='' type='hidden'>
				<input id='upload' name='art' value='' type='hidden'>
				<input  name='sing_st' value='<?php echo htmlentities($flowinfo['sing_st']); ?>' type='hidden'>
				<?php if($flowinfo['sing_st'] == 0): ?>
					<a class="btn btn-primary radius" id='nexbton' onclick='tj("ok")' >提交</a> 
					<?php if($flowinfo['process']['is_back'] != 2): ?>
					<a class="btn btn-primary radius" id='backbton' onclick='tj("back")'value='back' >回退</a> 
					<?php endif; if($flowinfo['process']['is_sing'] != 2): ?>
					<a class="btn btn-primary radius" id='singbton' onclick='tj("sing")' value='sing' >会签</a>
					<?php endif; ?>
					<a class="btn btn-primary radius" id='bupload'onclick="layer_show('上传','<?php echo url('wfup', ['id' => 'upload']); ?>','140','160')">附件</a> 
				<?php else: ?>
					<a class="btn btn-primary radius" id='nexbton' onclick='sing("sok")' >会签提交</a> 
					<a class="btn btn-primary radius" id='backbton' onclick='sing("sback")'value='back' >会签回退</a> 
					<a class="btn btn-primary radius" id='singbton' onclick='sing("ssing")' value='sing' >再会签</a>
				<?php endif; ?>
				
				</td>
				</tr>
				</table>
			</td>
			<td valign="top" >
				<div style='width:98%;overflow-y:scroll; height:200px'>
					<?php echo app\index\controller\wf::wflogs($info['wf_fid'],$info['wf_type']); ?>
				
				</div>
			</td>
			</tr>
		</table>
</form>		
		<table class="table table-border table-bordered mt-20" style='width:98%'>
		<tr><td>
		
		<iframe src="<?php echo url($info['wf_type'].'/'.$flowinfo['status']['wf_action'],['id'=>$info['wf_fid']]); ?>" id="iframepage" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" onLoad="iFrameHeight()"></iframe>
		
		</td></tr>
		</table>
	
</div>

<script type="text/javascript">
$(function(){
	$("#forms").Validform({
            tiptype:2,
            ajaxPost:true,
            showAllError:true,
            callback:function(ret){
                ajax_progress(ret);
            }
        });
});
function tj(value){
	if(value =='back'){
		$('#nex_process').hide();//
		$('#nexbton').hide();
		$('#singbton').hide();
		$('#backbton').html('确认回退');
		$('#back_process').show();
		var select = $('#backflow option:selected').val();
		$("#singflow").removeAttr("datatype");
		if(select==''){
			layer.msg('请选择回退步骤');
			return false;
		}
	}
	if(value =='sing'){
		$('#nex_process').hide();//
		$('#nexbton').hide();
		$('#backbton').hide();
		$('#backbton').html('确认会签');
		$('#sing_process').show();
		$("#backflow").removeAttr("datatype");
		var select = $('#singflow option:selected').val();
		if(select==''){
			layer.msg('请选择会签人');
			return false;
		}
	}
	if(value =='ok'){
		$("#backflow").removeAttr("datatype");
		$("#singflow").removeAttr("datatype");
	}
	$('#submit_to_save').val(value);
	$('#forms').submit();
}
function sing(value){
	if(value =='sback'){
		$('#nex_process').hide();//
		$('#nexbton').hide();
		$('#singbton').hide();
		$('#backbton').html('确认回退');
		$('#back_process').show();
		var select = $('#backflow option:selected').val();
		$("#singflow").removeAttr("datatype");
		if(select==''){
			layer.msg('请选择回退步骤');
			return false;
		}
	}
	if(value =='ssing'){
		$('#nex_process').hide();//
		$('#nexbton').hide();
		$('#backbton').hide();
		$('#backbton').html('确认会签');
		$('#sing_process').show();
		$("#backflow").removeAttr("datatype");
		var select = $('#singflow option:selected').val();
		if(select==''){
			layer.msg('请选择会签人');
			return false;
		}
	}
	if(value =='sok'){
		$("#backflow").removeAttr("datatype");
		$("#singflow").removeAttr("datatype");
	}
	$('#submit_to_save').val(value);
	$('#forms').submit();
} 
function iFrameHeight() {   
		var ifm= document.getElementById("iframepage");   
		var subWeb = document.frames ? document.frames["iframepage"].document : ifm.contentDocument;   
		if(ifm != null && subWeb != null) {
		   ifm.height = subWeb.body.scrollHeight;
		   ifm.width = '100%';
		}   
} 
function find(){
	$.post("<?php echo url('ajax_back'); ?>",{"back_id":$('#backflow').val(),"run_id":$('#run_id').val()},function(data){
				if(data != ''){
					$('#btodo').val(data);
				}
				
			},'json');
}
</script>
<!--/请在上方写此页面业务相关的脚本-->
</body>
</html>