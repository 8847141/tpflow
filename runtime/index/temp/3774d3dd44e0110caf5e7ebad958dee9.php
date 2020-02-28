<?php /*a:2:{s:65:"C:\Users\Administrator\web\tpflow\app\index\view\index\index.html";i:1582850418;s:62:"C:\Users\Administrator\web\tpflow\app\index\view\pub\base.html";i:1581909452;}*/ ?>
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
<header class="navbar-wrapper">
	<div class="navbar navbar-fixed-top">
		<div class="container-fluid cl"> <a class="logo navbar-logo f-l mr-10 hidden-xs" href="<?php echo url('index'); ?>">
		Tpflow</a> <a class="logo navbar-logo-m f-l mr-10 visible-xs" href="/aboutHui.shtml"></a> 
			<span class="logo navbar-slogan f-l mr-10 hidden-xs"> V4.0 for Thinkphp6.0.2</span> 
			<span class='logo navbar-slogan f-l mr-10 hidden-xs'><b>工作流插件</b>  </span>
			<span class='logo navbar-slogan f-l mr-10 hidden-xs'>开源协议：MIT  </span>
			<span class='logo navbar-slogan f-l mr-10 hidden-xs'>作者：蝈蝈（1838188896） 交流群：532797225</span>
		</nav>
		<nav id="Hui-userbar" class="nav navbar-nav navbar-userbar hidden-xs">
			<ul class="cl">
				<li><?php if(session("uid")): ?>
欢迎您：<?php echo session('uname'); else: ?>
	请先模拟登入！
<?php endif; ?></li>
				<li class="dropDown dropDown_hover">
					<a href="#" class="dropDown_A">切换账户 <i class="Hui-iconfont">&#xe6d5;</i></a>
					<ul class="dropDown-menu menu radius box-shadow">
						<?php if(is_array($user) || $user instanceof \think\Collection || $user instanceof \think\Paginator): $i = 0; $__LIST__ = $user;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$k): $mod = ($i % 2 );++$i;?>
							<li><a href="<?php echo url('login',['id'=>$k['id'],'user'=>$k['username'],'role'=>$k['role']]); ?>"><?php echo htmlentities($k['username']); ?></a></li>
						<?php endforeach; endif; else: echo "" ;endif; ?>
				</ul>
			</li>
			</ul>
		</nav>
	</div>
</div>
</header>
<!--左侧菜单开始-->
<aside class="Hui-aside">
		<div class="menu_dropdown bk_2" >
			<dl>
				<dt><i class="Hui-iconfont"></i> 测试业务<i class="Hui-iconfont menu_dropdown-arrow"></i></dt>
				<dd style="display: block;"><ul>
				<li><a data-href="<?php echo url('news/index'); ?>" data-title="测试业务" href="javascript:void(0)">测试业务</a></li>
				</dd>
				</dl>
			<dl>
			<dl>
				<dt><i class="Hui-iconfont"></i> 工作流设计<i class="Hui-iconfont menu_dropdown-arrow"></i></dt>
				<dd style="display: block;"><ul>
				<li><a data-href="<?php echo url('wf/wfindex'); ?>" data-title="工作流列表" href="javascript:void(0)">工作流列表</a></li>
				<li><a data-href="<?php echo url('wf/wfjk'); ?>" data-title="工作流监控" href="javascript:void(0)">工作流监控</a></li>
				<li><a data-href="<?php echo url('wf/wfgl'); ?>" data-title="工作流管理" href="javascript:void(0)">工作流管理</a></li>
				</dd>
			</dl>
			<dl>
				<dt><i class="Hui-iconfont"></i> 在线帮助<i class="Hui-iconfont menu_dropdown-arrow"></i></dt>
				<dd style="display: block;"><ul>
				<li><a data-href="http://www.cojz8.com" data-title="官方博客" href="javascript:void(0)">官方博客</a></li>
				<li><a data-href="<?php echo url('doc'); ?>" data-title="在线开发文档（精简）" href="javascript:void(0)">在线开发文档（精简）</a></li>
				<li><a data-href="https://www.kancloud.cn/guowenbin/tpflow/" data-title="看云完整文档" href="javascript:void(0)">看云完整文档</a></li>
				<li><a data-href="https://gitee.com/ntdgg/tpflow/" data-title="源码下载" href="javascript:void(0)">源码下载
				
				
				</a></li>
				</dd>
			</dl>
			
		</div>	
</div>
</aside>
<!--左侧菜单结束-->
<div class="dislpayArrow hidden-xs"><a class="pngfix" href="javascript:void(0);" onClick="displaynavbar(this)"></a></div>
<section class="Hui-article-box">
	<div id="Hui-tabNav" class="Hui-tabNav hidden-xs">
		<div class="Hui-tabNav-wp">
			<ul id="min_title_list" class="acrossTab cl">
				<li class="active">
					<span title="我的桌面" data-href="welcome.html">我的桌面</span><em></em></li>
		</ul>
	</div>
		<div class="Hui-tabNav-more btn-group"><a id="js-tabNav-prev" class="btn radius btn-default size-S" href="javascript:;"><i class="Hui-iconfont">&#xe6d4;</i></a><a id="js-tabNav-next" class="btn radius btn-default size-S" href="javascript:;"><i class="Hui-iconfont">&#xe6d7;</i></a></div>
</div>
	<div id="iframe_box" class="Hui-article">
		<div class="show_iframe">
			<div style="display:none" class="loading"></div>
			<iframe scrolling="yes" frameborder="0" src="<?php echo url('index/welcome'); ?>"></iframe>
	</div>
</div>
</section>
<script>
var session ="<?php echo session('uid'); ?>";
if(session =='' ){
layer.open({
      type: 2,
      title: '网站',
      shadeClose: true,
      shade: false,
      maxmin: true, //开启最大化最小化按钮
      area: ['493px', '600px'],
      content: '//cojz8.com/'
    });
	}
</script>
</body>
</html>