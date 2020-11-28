/*!
 * SFDP 表单设计器---公用方法库
 * http://cojz8.com
 *
 * 
 * Released under the MIT license
 * http://cojz8.com
 *
 * Date: 2020年3月4日23:34:39
 */
var Debug = false;//是否开启打印模式
var commonfun = {  
	ShowTip : function(tip) {
		layer.msg(tip);
	},
	returnShow : function(data, callback, param){
		 if (data.code == 0) {
			layer.msg(data.msg,{icon:1,time: 1500},function(){
					parent.location.reload(); // 父页面刷新
			});          
		} else {
		   layer.alert(data.msg, {title: "错误信息", icon: 2});
		}	
	},
	Askshow : function(url,msg){
		layer.confirm(msg,function(index){
			commonfun.sGet(url);
		});
	},
	sGet : function(url,msg='操作成功'){
		$.get(url,function(data,status){
			if(status=='success'){
					 if (data.code == 0) {
						layer.msg(msg,{icon:1,time: 1500},function(){
							location.reload();
						});          
					}else{
					   layer.alert(data.msg, {title: "错误信息", icon: 2});
					}	
			}else{
				 layer.alert("状态: " + status, {title: "错误信息", icon: 2});
			}
			
		});
	
    },
	sAjax : function(url,data){
		$.ajax({  
			 url:url,
			 data:data,  
			 type:'post',  
			 cache:true,  
			dataType:'json',			 
			 success:function(ret) {  
				 if (ret.code == 0) {
						layer.msg(ret.msg,{icon:1,time: 1500},function(){
							location.reload();
						});          
					}else{
					   layer.alert(ret.msg, {title: "错误信息", icon: 2});
					}
			  },  
			  error : function() {  
						layer.alert('请求出错！', {title: "错误信息", icon: 2});
			  }  
		 }); 
	},
}