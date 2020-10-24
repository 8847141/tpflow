<?php
/**
 *+------------------
 * Tpflow 模板驱动类
 *+------------------
 * Copyright (c) 2006~2018 http://cojz8.cn All rights reserved.
 *+------------------
 * Author: guoguo(1838188896@qq.com)
 *+------------------
 */

namespace tpflow;

use tpflow\workflow;
//数据库操作
use tpflow\db\InfoDb;
use tpflow\db\FlowDb;
use tpflow\db\ProcessDb;
use tpflow\db\LogDb;
use tpflow\db\UserDb;
use tpflow\db\WorkDb;
use tpflow\db\EntrustDb;
use tpflow\lib\lib;

use think\facade\Request;

define('BEASE_LIB', realpath ( dirname ( __FILE__ ) ).'/lib/' );
require_once ( BEASE_LIB . 'unit.php');//加载工具配置

	class Api{
		public $patch = '';
		function __construct(Request $request) {
			$this->work = new workflow();
			$this->lib = new lib();
			$this->uid = session(gconfig('user_id'));
			$this->role = session(gconfig('role_id'));
			$this->table  = InfoDb::get_wftype();
			$this->patch =  ROOT_PATH . 'extend/tpflow/view';
			$this->request = $request;
	   }
	/**
	 * 版权信息，请勿删除
	 * 授权请联系：632522043@qq.com
	 */
	public function welcome(){
		return '<br/><br/><style type="text/css">*{ padding: 0; margin: 0; } div{ padding: 4px 48px;} a{color:#2E5CD5;cursor: pointer;text-decoration: none} a:hover{text-decoration:underline; }h1{ font-size: 40px; font-weight: normal; margin-bottom: 12px; } p{ line-height: 1.6em; font-size: 35px }</style><div style="padding: 24px 48px;"> <h1>\﻿ (•◡•) / </h1><p> TpFlow V4.0开发版<br/><span style="font-size:19px;">PHP开源工作流引擎系统</span></p><span style="font-size:15px;">[ ©2018-2020 Guoguo <a href="https://www.cojz8.com/">TpFlow</a> 本版权不可删除！ ]</span></div>';
    }
	public static function wflogs($id,$wf_type,$type='html'){
		$work = new workflow();
		$logs = $work->FlowLog('logs',$id,$wf_type);
		echo $logs[$type];
	}
	public static function wfbtn($wf_fid,$wf_type,$status)
	{
		$work = new workflow();
		$lib = new lib();
		$user = ['thisuid'=>session(gconfig('user_id')),'thisrole'=>session(gconfig('role_id'))];
		$url = ['url'=>url("/".gconfig('int_url')."/wf/wfcheck/",["wf_type"=>$wf_type,"wf_title"=>'2','wf_fid'=>$wf_fid]),'url_star'=>url("/".gconfig('int_url')."/wf/wfstart/",["wf_type"=>$wf_type,"wf_title"=>'2','wf_fid'=>$wf_fid])];
		return $lib->tpflow_btn($wf_fid,$wf_type,$status,$url,$user,$work);
	}
	 
	 public static function wfstatus($status)
	{
		$lib = new lib();
		return $lib->tpflow_status($status);
	}
	/*发起流程，选择工作流*/
	public function wfstart()
	{
		$info = ['wf_type'=>input('wf_type'),'wf_title'=>input('wf_title'),'wf_fid'=>input('wf_fid')];
		$flow =  $this->work->getWorkFlow(input('wf_type'));
		return view($this->patch.'/wfstart.html',['int_url'=>gconfig('int_url'),'info'=>$info,'flow'=>$flow]);
	}
	/*正式发起工作流*/
	public function statr_save()
	{
		$data = input('post.');
		$flow = $this->work->startworkflow($data,$this->uid);
		if($flow['code']==1){
			return msg_return('Success!');
		}
	}
	public function wfcheck()
	{
		$info = ['wf_title'=>input('wf_title'),'wf_fid'=>input('wf_fid'),'wf_type'=>input('wf_type')];
		return view($this->patch.'/wfcheck.html',['int_url'=>gconfig('int_url'),'info'=>$info,'flowinfo'=>$this->work->workflowInfo(input('wf_fid'),input('wf_type'),['uid'=>$this->uid,'role'=>$this->role])]);
	}
	public function do_check_save()
	{
		$data = input('post.');
		$flowinfo =  $this->work->workdoaction($data,$this->uid);
		if($flowinfo['code']=='0'){
			return msg_return('Success!');
			}else{
			return msg_return($flowinfo['msg'],1);
		}
	}
	
	/**
	 * 流程设计首页
	 * @param $map 查询参数
	 */
	public function wfindex($map = []){
		$type = [];
		foreach($this->table as $k=>$v){
			$type[$v['name']] = str_replace('[work]', '', $v['title']);;
		}
		return view($this->patch.'/wfindex.html',['int_url'=>gconfig('int_url'),'type'=>$type,'list'=>$this->work->FlowApi('List')]);
    }
	/*流程监控*/
	public function wfjk($map = [])
	{
		return view($this->patch.'/wfjk.html',['int_url'=>gconfig('int_url'),'list'=>$this->work->worklist()]);
	}
	//用户选择控件
    public function super_user()
    {
	  $info=UserDb::GetUser();
	   $user ='';
	   foreach($info as $k=>$v){
		   $user .='<option value="'.$v['id'].'">'.$v['username'].'</option>'; 
	   }
	   return $this->lib->tmp_user(url(gconfig('int_url').'/wf/super_get'),input('kid'),$user);
    }
	//角色选择控件
    public function super_role()
    {
		$info=UserDb::GetRole();
	   $user ='';
	   foreach($info as $k=>$v){
			$user .='<option value="'.$v['id'].'">'.$v['username'].'</option>'; 
	   }
	   return $this->lib->tmp_role(url(gconfig('int_url').'/wf/super_get'),$user);
    }
	public function super_get()
	{
		 return ['data'=>UserDb::AjaxGet(trim(input('type')),input('key')),'code'=>1,'msg'=>'查询成功！'];
	}
	
		 /**
	 * 流程修改
	 */
	public function wfadd()
    {
        if ($this->request::isPost()) {
			$data = input('post.');
			if($data['id']==''){
				$data['uid']=$this->uid;
				$data['add_time']=time();
				unset($data['id']);
				$ret= $this->work->FlowApi('AddFlow',$data);
			}else{
				$ret= $this->work->FlowApi('EditFlow',$data);
			}
			if($ret['code']==0){
				return msg_return('操作成功！');
				}else{
				return msg_return($ret['data'],1);
			}
	   }
	   $id = input('id') ?? -1;
	   $info=$this->work->FlowApi('GetFlowInfo',$id);
	   $type ='';
	   foreach($this->table as $k=>$v){
		   $type .='<option value="'.$v['name'].'">'.$v['title'].'</option>'; 
	   }
	   return $this->lib->tmp_add(url(gconfig('int_url').'/wf/wfadd'),$info,$type);
    }
	/**
	 * 工作流设计界面
	 */
    public function wfdesc(){
		 
        $flow_id = intval(input('flow_id'));
        if($flow_id<=0){
            $this->error('参数有误，请返回重试!');
		}
        $one = $this->work->FlowApi('GetFlowInfo',$flow_id);
        if(!$one){
            $this->error('未找到数据，请返回重试!');
        }
		//Url转换地址
		$urls = [
			'welcome'=>url(gconfig('int_url').'/wf/welcome'),
			'add_process'=>url(gconfig('int_url').'/wf/add_process'),
			'Checkflow'=>url(gconfig('int_url').'/wf/Checkflow'),
			'save_canvas'=>url(gconfig('int_url').'/wf/save_canvas'),
			'del_allprocess'=>url(gconfig('int_url').'/wf/del_allprocess'),
			'delete_process'=>url(gconfig('int_url').'/wf/delete_process'),
			'wfatt'=>url(gconfig('int_url').'/wf/wfatt')
		];
		return view($this->patch.'/wfdesc.html',['url'=>$urls,'one'=>$one,'process_data'=>$this->work->ProcessApi('All',$flow_id)]);
    }
	public function Checkflow($fid){
		return $this->work->SuperApi('CheckFlow',$fid);
	}
	/**
	 * 添加流程
	 **/
    public function add_process()
    {
        $flow_id = input('flow_id');
        $one = $this->work->FlowApi('GetFlowInfo',$flow_id);
        if(!$one){
          return json(['status'=>0,'msg'=>'添加失败,未找到流程','info'=>'']);
        }
		return json($this->work->ProcessApi('ProcessAdd',$flow_id));
    }
	public function wfchange()
	{
		 if ($this->request::isGet()) {
			$data = ['id'=>input('id'),'status'=>input('status')];
			$ret= $this->work->FlowApi('EditFlow',$data);
			if($ret['code']==0){
					echo "<script language='javascript'>alert('操作成功！！'); top.location.reload();</script>";exit;
				}else{
					echo "<script language='javascript'>alert('操作失败！！'); top.location.reload();</script>";exit;
			
			}
		 }
	}
	/**
	 * 保存布局
	 **/
    public function save_canvas()
    {
		return json($this->work->ProcessApi('ProcessLink',input('flow_id'),input('process_info')));
    }
	public function save_attribute()
    {
	    $data = input('post.');
		return json($this->work->ProcessApi('ProcessAttSave',$data['process_id'],$data));
    }
	//步骤属性
    public function wfatt()
    {
	    $info = $this->work->ProcessApi('ProcessAttView',input('id'));
		return view($this->patch.'/wfatt.html',['int_url'=>gconfig('int_url'),'op'=>$info['show'],'one'=>$info['info'],'from'=>$info['from'],'process_to_list'=>$info['process_to_list'],'child_flow_list'=>$info['child_flow_list']]);
    }
	/**
	 * 删除流程
	 **/
   public function delete_process()
    {
		return json($this->work->ProcessApi('ProcessDel',input('flow_id'),input('process_id')));
    }
	public function del_allprocess()
	{
		return json($this->work->ProcessApi('ProcessDelAll',input('flow_id')));
	}
	public function wfgl()
    {
        return view($this->patch.'/wfgl.html',['int_url'=>gconfig('int_url'),'list'=>EntrustDb::lists()]);
    }
	/*委托授权审核*/
	public function entrust(){
		
		if ($this->request::isPost()) {
			$post = input('post.');
			$ret = EntrustDb::Add(1,$post);
			if($ret['code']==0){
				return msg_return('发布成功！');
				}else{
				return msg_return($ret['data'],1);
			}
	   }
		//获取全部跟自己相关的步骤
		$data =ProcessDb::get_userprocess($this->uid,$this->role);
		$url = url(gconfig('int_url').'/wf/entrust');
		$type ='';
		   foreach($data as $k=>$v){
			   $type .='<option value="'.$v['id'].'@'.$v['flow_id'].'">['.$v['flow_name'].']'.$v['process_name'].'</option>'; 
		   }
		  $user = UserDb::GetUser();
		  foreach($user as $k=>$v){
			   $user .='<option value="'.$v['id'].'@'.$v['username'].'">'.$v['username'].'</option>'; 
		  }
		$info = EntrustDb::find(input('id'));
	   return $this->lib->tmp_entrust($url,$info,$type,$user);
	}
	public function wfup()
    {
		if ($this->request::isPost()) {
			$files = $this->request::file('file');
			foreach ($files as $file) {
				$info = \think\facade\Filesystem::disk('public')->putFile( 'uploads', $file);
				if ($info) {
					$data[] = $info;
				} else {
					$error[] = $info;
				}
			}
			return msg_return($data,0,$info);
		}
	   return $this->lib->tmp_upload(url(gconfig('int_url').'/wf/wfup'),input('id'));
    }
	public function ajax_back()
	{
		$flowinfo =  $this->work->getprocessinfo(input('back_id'),input('run_id'));
		return $flowinfo;
	}
	
	public function wfend()
	{
		$flowinfo =  $this->work->SuperApi('WfEnd',input('get.id'),$this->uid);
		return msg_return('Success!');
	}
	
}
	