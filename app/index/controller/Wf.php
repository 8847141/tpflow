<?php
namespace app\index\Controller;
use app\Basec;
use think\facade\Db;
use workflow\workflow;
use think\facade\View;

class wf2 extends Basec {
	public static function Tmp(){
		return '../extend/workflow/view/';
	}
	public static function uid(){
		return session('uid');
	}
	public static function role(){
		return session('role');
	}
	public static function work(){
		return new workflow();
	}
    /**
	 * 流程设计首页
	 * @param $map 查询参数
	 */
    public function wfindex2($map = []){
        View::assign('list',self::work()->FlowApi('List'));
		View::assign('type', ['news'=>'新闻信息','cnt'=>'合同信息','paper'=>'证件信息']);
        return  View::fetch();
    }
	/**
	 * 工作流设计界面
	 */
    public function wfdesc(){
		 
        $flow_id = intval(input('flow_id'));
        if($flow_id<=0){
            $this->error('参数有误，请返回重试!');
		}
        $one = self::work()->FlowApi('GetFlowInfo',$flow_id);
        if(!$one){
            $this->error('未找到数据，请返回重试!');
        }
        View::assign('one', $one);
        View::assign('process_data',self::work()->ProcessApi('All',$flow_id));
        return View::fetch();
    }
    /**
	 * 流程添加
	 */
    public function wfadd()
    {
		if ($this->request->isPost()) {
			$data = input('post.');
			$data['uid']=session('uid');
			$data['add_time']=time();
			$ret= self::work()->FlowApi('AddFlow',$data);
			if($ret['code']==0){
				return $this->msg_return('发布成功！');
				}else{
				return $this->msg_return($ret['data'],1);
			}
	   }
	   View::assign('type', ['news'=>'新闻信息','cnt'=>'合同信息','paper'=>'证件信息']);
       return  View::fetch();
    }
	 /**
	 * 流程修改
	 */
	public function wfedit()
    {
        if ($this->request->isPost()) {
			$data = input('post.');
			$ret= self::work()->FlowApi('EditFlow',$data);
			if($ret['code']==0){
				return $this->msg_return('修改成功！');
				}else{
				return $this->msg_return($ret['data'],1);
			}
	   }
	   if(input('id')){
		 View::assign('info', self::work()->FlowApi('GetFlowInfo',input('id')));
	   }
	   View::assign('type', ['news'=>'新闻信息','cnt'=>'合同信息','paper'=>'证件信息']);
       return View::fetch('wfadd');
    }
	/**
	 * 状态改变
	 */
	public function wfchange()
	{
		 if ($this->request->isGet()) {
			$data = ['id'=>input('id'),'status'=>input('status')];
			$ret= self::work()->FlowApi('EditFlow',$data);
			if($ret['code']==0){
				$this->success('操作成功',url('wf/wfindex'));
				}else{
				$this->error('操作失败！',url('wf/wfindex'));
			}
		 }
	}
	
    /**
	 * 删除流程
	 **/
   public function delete_process()
    {
		return json(self::work()->ProcessApi('ProcessDel',input('flow_id'),input('process_id')));
    }
	public function del_allprocess()
	{
		return json(self::work()->ProcessApi('ProcessDelAll',input('flow_id')));
	}
	/**
	 * 添加流程
	 **/
    public function add_process()
    {
        $flow_id = input('flow_id');
        $one = self::work()->FlowApi('GetFlowInfo',$flow_id);
        if(!$one){
          return json(['status'=>0,'msg'=>'添加失败,未找到流程','info'=>'']);
        }
		return json(self::work()->ProcessApi('ProcessAdd',$flow_id));
    }
    /**
	 * 保存布局
	 **/
    public function save_canvas()
    {
		return json(self::work()->ProcessApi('ProcessLink',input('flow_id'),input('process_info')));
    }
    //右键属性
    public function wfatt()
    {
	    $info = self::work()->ProcessApi('ProcessAttView',input('id'));
	    View::assign('op',$info['show']);
        View::assign('one',$info['info']);
		View::assign('from',$info['from']);
        View::assign('process_to_list',$info['process_to_list']);
        View::assign('child_flow_list',$info['child_flow_list']);
		return View::fetch();
    }
    public function save_attribute()
    {
	    $data = input('post.');
		return json(self::work()->ProcessApi('ProcessAttSave',$data['process_id'],$data));
    }
   
	//用户选择控件
    public function super_user()
    {
		View::assign('user',Db::name('user')->field('id,username')->select());
		View::assign('kid',input('kid'));
        return View::fetch();
    }
	//用户选择控件
    public function super_role()
    {
		View::assign('role',Db::name('role')->field('id,name as username')->select());
        return View::fetch();
    }
	public function super_get()
	{
		 $type = trim(input('type'));
		 if($type=='user'){
			$info =  Db::name('user')->where('username','like','%'.input('key').'%')->field('id as vlaue,username as text')->select();
		 }else{
			 $info =  Db::name('role')->where('name','like','%'.input('key').'%')->field('id as vlaue,name as text')->select();
		 }
		 return ['data'=>$info,'code'=>1,'msg'=>'查询成功！'];
	}
	/*流程监控*/
	public function wfjk($map = [])
	{
		View::assign('list', self::work()->worklist());
		return View::fetch();
	}
	public static function btn($wf_fid,$wf_type,$status)
	{
		$url = url("/index/wf/wfcheck/",["wf_type"=>$wf_type,"wf_title"=>'2','wf_fid'=>$wf_fid]);
		$url_star = url("/index/wf/wfstart/",["wf_type"=>$wf_type,"wf_title"=>'2','wf_fid'=>$wf_fid]);
		switch ($status)
		{
		case 0:
		  return '<span class="btn  radius size-S" onclick=layer_show(\'发起工作流\',"'.$url_star.'","450","350")>发起工作流</span>';
		  break;
		case 1:
			$st = 0;
			$user_name ='';
			
			$flowinfo =  self::work()->workflowInfo($wf_fid,$wf_type,['uid'=>self::uid(),'role'=>self::role()]);
			
			if($flowinfo!=-1){
				if(!isset($flowinfo['status'])){
					 return '<span class="btn btn-danger  radius size-S" onclick=javascript:alert("提示：当前流程故障，请联系管理员重置流程！")>Info:Flow Err</span>';
				}
					if($flowinfo['sing_st']==0){
						$user = explode(",", $flowinfo['status']['sponsor_ids']);
						$user_name =$flowinfo['status']['sponsor_text'];
						if($flowinfo['status']['auto_person']==3||$flowinfo['status']['auto_person']==4||$flowinfo['status']['auto_person']==6){
							if (in_array(self::uid(), $user)) {
								$st = 1;
							}
						}
						if($flowinfo['status']['auto_person']==5){
							if (in_array(self::role(), $user)) {
								$st = 1;
							}
						}
					}else{
						if($flowinfo['sing_info']['uid']==self::uid()){
							  $st = 1;
						}else{
							   $user_name =$flowinfo['sing_info']['uid'];
						}
					}
				}else{
					 return '<span class="btn  radius size-S">无权限</span>';
				}	
				if($st == 1){
					 return '<span class="btn  radius size-S" onclick=layer_show(\'审核\',"'.$url.'","850","650")>审核('.$user_name.')</span>';
					}else{
					 return '<span class="btn  radius size-S">无权限('.$user_name.')</span>';
				}
			
		case 100:
			echo '<span class="btn btn-primary" onclick=layer_show(\'代审\',"'.$url.'?sup=1","850","650")>代审</span>';
		  break;
		  break;
		default:
		  return '';
		}
	}
	public static function status($status)
	{
		switch ($status)
		{
		case 0:
		  return '<span class="label radius">保存中</span>';
		  break;
		case 1:
		  return '<span class="label radius" >流程中</span>';
		  break;
		case 2:
		  return '<span class="label label-success radius" >审核通过</span>';
		  break;
		default: //-1
		  return '<span class="label label-danger radius" >退回修改</span>';
		}
	}
	
    /*发起流程，选择工作流*/
	public function wfstart()
	{
		$info = ['wf_type'=>input('wf_type'),'wf_title'=>input('wf_title'),'wf_fid'=>input('wf_fid')];
		$flow =  self::work()->getWorkFlow(input('wf_type'));
		View::assign('flow',$flow);
		View::assign('info',$info);
		return View::fetch();
	}
	/*正式发起工作流*/
	public function statr_save()
	{
		$data = $this->request->param();
		$flow = self::work()->startworkflow($data,self::uid());
		if($flow['code']==1){
			return $this->msg_return('Success!');
		}
	}
	
	public function wfcheck()
	{
		$info = ['wf_title'=>input('wf_title'),'wf_fid'=>input('wf_fid'),'wf_type'=>input('wf_type')];
		View::assign('info',$info);
		View::assign('flowinfo',self::work()->workflowInfo(input('wf_fid'),input('wf_type'),['uid'=>self::uid(),'role'=>self::role()]));
		return View::fetch();
	}
	public function do_check_save()
	{
		$data = $this->request->param();
		$flowinfo =  self::work()->workdoaction($data,self::uid());
		
		if($flowinfo['code']=='0'){
			return $this->msg_return('Success!');
			}else{
			return $this->msg_return($flowinfo['msg'],1);
		}
	}
	public function ajax_back()
	{
		$flowinfo =  self::work()->getprocessinfo(input('back_id'),input('run_id'));
		return $flowinfo;
	}
	public function Checkflow($fid){
		return self::work()->SuperApi('CheckFlow',$fid);
	}
	
	 public function wfup()
    {
        return View::fetch();
    }
	
	public function wfend()
	{
		$flowinfo =  self::work()->SuperApi('WfEnd',input('get.id'),self::uid());
		return $this->msg_return('Success!');
	}
	public function wfupsave()
    {
        $files = $this->request->file('file');
        $insert = [];
        foreach ($files as $file) {
            $path = \Env::get('root_path') . '/public/uploads/';
            $info = $file->move($path);
            if ($info) {
                $data[] = $info->getSaveName();
            } else {
                $error[] = $file->getError();
            }
        }
        return $this->msg_return($data,0,$info->getInfo('name'));
    }
	public function msg_return($msg = "操作成功！", $code = 0,$data = [],$redirect = 'parent',$alert = '', $close = false, $url = '')
	{
		$ret = ["code" => $code, "msg" => $msg, "data" => $data];
		$extend['opt'] = [
			'alert'    => $alert,
			'close'    => $close,
			'redirect' => $redirect,
			'url'      => $url,
		];
		$ret = array_merge($ret, $extend);
		return json($ret);
	}
	public static function wflogs($id,$wf_type,$type='html'){
		$logs = self::work()->FlowLog('logs',$id,$wf_type);
		echo $logs[$type];
	}
	public function wfgl(){
		return View::fetch(self::Tmp().'wfgl.html');
	}
}