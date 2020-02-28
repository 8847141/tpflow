<?php /*a:2:{s:67:"C:\Users\Administrator\web\tpflow\app\index\view\wf\super_user.html";i:1581909452;s:62:"C:\Users\Administrator\web\tpflow\app\index\view\pub\base.html";i:1581909452;}*/ ?>
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
<link rel="stylesheet" type="text/css" href="/static/work/multiselect2side.css" media="screen" />
<script type="text/javascript" src="/static/work/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="/static/work/multiselect2side.js" ></script>
<article class="page-container">
<table class="table table-bordered table-bg">
			<tr><td>
	<form method="post">
		<div class="text-l">
			<input type="text" id="key" style="width:150px" class="input-text">
			<a id="search" class="btn btn-success size-S">搜人员</a>
			</div>
		</form>
			</td></tr>
			<tr><td>
			 <select name="dialog_searchable" id="dialog_searchable" multiple="multiple" style="display:none;">
			<?php if(is_array($user) || $user instanceof \think\Collection || $user instanceof \think\Paginator): $i = 0; $__LIST__ = $user;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$k): $mod = ($i % 2 );++$i;?>
            <option value="<?php echo htmlentities($k['id']); ?>" ><?php echo htmlentities($k['username']); ?></option>
			<?php endforeach; endif; else: echo "" ;endif; ?>
			</select>
			</td></tr>
			<tr><td>
			<button class="btn btn-info" type="button" onclick='call_back()' id="dialog_confirm">确定</button>
			<button class="btn" type="button" id="dialog_close">取消</button>
			</td></tr>
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
		parent.$('#<?php echo htmlentities($kid); ?>_ids').val(ids);
		parent.$('#<?php echo htmlentities($kid); ?>_text').val(name);
		parent.$('#<?php echo htmlentities($kid); ?>_html').html(html);
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
			var url = "<?php echo url('super_get'); ?>";
			$.post(url,{"type":'user',"key":$('#key').val()},function(data){
				layer.msg(data.msg);
				var userdata = data.data;
				var optionList = [];
            for(var i=0;i<userdata.length;i++){
                optionList.push('<option value="');
                optionList.push(userdata[i].value);
                optionList.push('">');
                optionList.push(userdata[i].text);
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