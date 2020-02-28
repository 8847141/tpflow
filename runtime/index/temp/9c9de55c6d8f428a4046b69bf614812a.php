<?php /*a:2:{s:63:"C:\Users\Administrator\web\tpflow\app\index\view\wf\wfdesc.html";i:1581909452;s:62:"C:\Users\Administrator\web\tpflow\app\index\view\pub\base.html";i:1581909452;}*/ ?>
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
 <body  style="height: 100%; overflow: hidden;margin: 0px; padding: 0px;"> 
  <div class="panel layout-panel panel-west split-west" style="left: 0px; width:145px; cursor: default;">
   <div class="panel-body"> 
     <div class="panel" style="width: 140px;">
      <div class="panel-header">功能栏</div>
	  <div class="panel-body" style='text-align:center'>
		 欢迎使用流程设计器~<br/><br/>
		  <button class="btn btn-info" type="button" id="wfSave">保存设计</button><br/><br/>
		  <button class="btn btn-info" type="button" id="wfAdd">新增步骤</button><br/><br/>
		  <button class="btn btn-info" type="button" id="wfCheck">逻辑检查</button><br/><br/>
		  <button class="btn btn-info" type="button" id="wfCleam">清空步骤</button><br/><br/>
		  <button class="btn btn-info" type="button" id="wfHelp">设计帮助</button><br/><br/>
		  <button class="btn btn-info" type="button" id="wfRefresh">刷新设计</button><br/><br/>
      </div></div> 
   </div>
  </div> 
  <div class="panel layout-panel split-center" style="left:150px;  width:calc(100% - 645px); cursor: default;" > 
	<div  class="panel-body">
     <div class="panel" >
      <div class="panel-header">流程设计栏</div>
	  <div class="panel-body" style="width:100%; height: 800px;" id="flowdesign_canvas"></div> 
     </div></div>
  </div> 
  <div class="panel layout-panel panel-west split-east split-west" style="left: calc(100% - 500px);  width:500px; cursor: default;">
    <div  class="panel-body"> 
     <div class="panel" >
      <div class="panel-header">属性控制栏</div>
	  <div class="panel-body" style='height: 800px;'>
		<iframe src="" id="iframepage" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" onLoad="iFrameHeight()"></iframe>
	  </div></div> 
   </div>
  </div> 
 </body>
</html>
<script type="text/javascript" src="/static/work/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="/static/work/jquery-ui-1.9.2-min.js?" ></script>
<script type="text/javascript" src="/static/work/jsPlumb-1.3.16-all-min.js"></script>
<script type="text/javascript" src="/static/work/workflow.3.0.js"></script>
<script type="text/javascript">
	function iFrameHeight() {   
		var ifm= document.getElementById("iframepage");   
		var subWeb = document.frames ? document.frames["iframepage"].document : ifm.contentDocument;   
		if(ifm != null && subWeb != null) {
		   ifm.height = '100%';
		   ifm.width = '100%';
		}   
	} 
var the_flow_id ='<?php echo htmlentities($one['id']); ?>';
$(function(){
    var attributeModal =  $("#attributeModal");
    //属性设置
    attributeModal.on("hidden", function() {
        $(this).removeData("modal");//移除数据，防止缓存
    });
    /*创建流程设计器*/
    var _canvas = $("#flowdesign_canvas").Flowdesign({
                      "processData":<?php echo $process_data; ?>
                      ,fnClick:function(){ /*步骤单击*/
						 var url = "<?php echo url('wfatt'); ?>?id="+_canvas.getActiveId();
						 $('#iframepage').attr('src',url);
                      },fnDbClick:function(){
						if(confirm("你确定删除步骤吗？")){
							var activeId = _canvas.getActiveId();//右键当前的ID
							var url = "<?php echo url('delete_process'); ?>";
							$.post(url,{"flow_id":the_flow_id,"process_id":activeId},function(data){
								if(data.status==1){
									_canvas.delProcess(activeId);
									var processInfo = _canvas.getProcessInfo();//连接信息
									var url = "<?php echo url('save_canvas'); ?>";
									$.post(url,{"flow_id":the_flow_id,"process_info":processInfo},function(data){
										location.reload();
									},'json');
								}
								layer.msg(data.msg);
							},'json');
                           }
                      }
         });
		/*保存*/
		$("#wfSave").bind('click',function(){
			var processInfo = _canvas.getProcessInfo();//连接信息
			var url = "<?php echo url('save_canvas'); ?>";
			$.post(url,{"flow_id":the_flow_id,"process_info":processInfo},function(data){
				layer.msg(data.msg);
			},'json');
		});
		$("#wfRefresh").bind('click',function(){
			  location.reload();
		});
		$("#wfHelp").bind('click',function(){
			  layer.open({
			  type: 2,
			  title: '工作流官网',
			  shadeClose: true,
			  shade: false,
			  maxmin: true, //开启最大化最小化按钮
			  area: ['893px', '600px'],
			  content: '//cojz8.com/'
			});
		});
		$("#wfCheck").bind('click',function(){
			  var url = "<?php echo url('Checkflow'); ?>";
			  $.post(url,{"fid":the_flow_id},function(data){
				if(data.status==1){
					layer.msg(data.msg);
					}else{
					layer.msg(data.msg);
				   }
				},'json');
		});
		$("#wfAdd").bind('click',function(){
			var url = "<?php echo url('add_process'); ?>";
			$.post(url,{"flow_id":the_flow_id},function(data){
			if(data.status==1){
				location.reload();
				}else{
				layer.msg("添加失败");
			   }
			},'json');
		});
		$("#wfCleam").bind('click',function(){
			if(confirm("你确定删除步骤吗？")){
				var url = "<?php echo url('del_allprocess'); ?>";
				$.post(url,{"flow_id":the_flow_id},function(data){
				if(data.status==1){
					location.reload();
					}else{
					layer.msg("添加失败");
				   }
				},'json');
			
			}
		});
});
</script>