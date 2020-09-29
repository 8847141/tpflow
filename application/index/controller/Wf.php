<?php
namespace app\index\Controller;
use app\common\controller\admin;
use think\Db;
use workflow\workflow;
use think\facade\Session;

class wf extends Admin {
    public function initialize()
    {
        parent::initialize();
        $this->work = new workflow();
		$this->uid = session('uid');
	    $this->role = session('role');
		$this->Tmp  = '../extend/workflow/view/';
		$this->table  = Db :: query("select replace(TABLE_NAME,'".config('database.prefix')."','')as name,TABLE_COMMENT as title from information_schema.tables where table_schema='".config('database.database')."' and table_type='base table' and TABLE_COMMENT like '[work]%';");
    }
	public function btn($wf_fid,$wf_type,$status)
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
			$flowinfo =  $this->work->workflowInfo($wf_fid,$wf_type,['uid'=>$this->uid,'role'=>$this->role]);
			if($flowinfo!=-1){
				if(!isset($flowinfo['status'])){
					 return '<span class="btn btn-danger  radius size-S" onclick=javascript:alert("提示：当前流程故障，请联系管理员重置流程！")>Info:Flow Err</span>';
				}
					if($flowinfo['sing_st']==0){
						$user = explode(",", $flowinfo['status']['sponsor_ids']);
						$user_name =$flowinfo['status']['sponsor_text'];
						if($flowinfo['status']['auto_person']==3||$flowinfo['status']['auto_person']==4||$flowinfo['status']['auto_person']==6){
							if (in_array($this->uid, $user)) {
								$st = 1;
							}
						}
						if($flowinfo['status']['auto_person']==5){
							if (in_array($this->role, $user)) {
								$st = 1;
							}
						}
					}else{
						if($flowinfo['sing_info']['uid']==$this->uid){
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
	public function status($status)
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
		$flow =  $this->work->getWorkFlow(input('wf_type'));
		$this->assign('flow',$flow);
		$this->assign('info',$info);
		return $this->fetch();
	}
	/*正式发起工作流*/
	public function statr_save()
	{
		$data = $this->request->param();
		$flow = $this->work->startworkflow($data,$this->uid);
		if($flow['code']==1){
			return $this->msg_return('Success!');
		}
	}
	
	public function wfcheck()
	{
		$info = ['wf_title'=>input('wf_title'),'wf_fid'=>input('wf_fid'),'wf_type'=>input('wf_type')];
		$this->assign('info',$info);
		$this->assign('flowinfo',$this->work->workflowInfo(input('wf_fid'),input('wf_type'),['uid'=>$this->uid,'role'=>$this->role]));
		return $this->fetch();
	}
	public function do_check_save()
	{
		$data = $this->request->param();
		$flowinfo =  $this->work->workdoaction($data,$this->uid);
		
		if($flowinfo['code']=='0'){
			return $this->msg_return('Success!');
			}else{
			return $this->msg_return($flowinfo['msg'],1);
		}
	}
	public function ajax_back()
	{
		$flowinfo =  $this->work->getprocessinfo(input('back_id'),input('run_id'));
		return $flowinfo;
	}
	public function Checkflow($fid){
		return $this->work->SuperApi('CheckFlow',$fid);
	}
	
	 public function wfup()
    {
        return $this->fetch();
    }
	
	public function wfend()
	{
		$flowinfo =  $this->work->SuperApi('WfEnd',input('get.id'),$this->uid);
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
	public function wflogs($id,$wf_type,$type='html'){
		$logs = $this->work->FlowLog('logs',$id,$wf_type);
		echo $logs[$type];
	}
	public function wfgl(){
		return $this->fetch($this->Tmp.'wfgl.html');
	}
}