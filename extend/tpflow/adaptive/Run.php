<?php
/**
 *+------------------
 * Tpflow 统一标准接口------代理模式数据库操作统一接口
 *+------------------
 * Copyright (c) 2006~2018 http://cojz8.cn All rights reserved.
 *+------------------
 * Author: guoguo(1838188896@qq.com)
 *+------------------
 */
namespace tpflow\adaptive;

use tpflow\lib\unit;

Class Run{
    
	protected $mode ; 
    public function  __construct(){
		if(unit::gconfig('wf_db_mode')==1){
			$className = '\\tpflow\\custom\\think\\AdapteeRun';
		}else{
			$className = unit::gconfig('wf_db_namespace').'AdapteeRun';
		}
		$this->mode = new $className();
    }
	
	static function AddRun($data)
    {
       return (new Run())->mode->AddRun($data);
    }
	static function FindRunId($id,$field='*')
    {
       return (new Run())->mode->FindRunId($id,$field);
    }
	static function  EditRun($id,$data)
    {
       return (new Run())->mode->EditRun($id,$data);
    }
    static function FindRun($where=[],$field='*')
    {
		return (new Run())->mode->FindRun($where,$field);
    }
	 static function SearchRun($where=[],$field='*')
    {
		return (new Run())->mode->SearchRun($where,$field);
    }
	/*run_process表操作接口代码*/
	static function FindRunProcessId($id,$field='*')
    {
       return (new Run())->mode->FindRunProcessId($id,$field);
    }
	static function FindRunProcess($where=[],$field='*')
    {
		return (new Run())->mode->FindRunProcess($where,$field);
    }
	static function AddRunProcess($data)
    {
       return (new Run())->mode->AddRunProcess($data);
    }
	static function SearchRunProcess($where=[],$field='*')
    {
       return (new Run())->mode->SearchRunProcess($where,$field);
    }
	static function EditRunProcess($where=[],$data)
    {
       return (new Run())->mode->EditRunProcess($where,$data);
    }
	/*FindRunSign表操作接口代码*/
	static function FindRunSign($where=[],$field='*')
    {
		return (new Run())->mode->FindRunSign($where,$field);
    }
	static function AddRunSing($config)
    {
		$data = [
			'run_id'=>$config['run_id'],
			'run_flow'=>$config['flow_id'],
			'run_flow_process'=>$config['run_process'],
			'uid'=>$config['wf_singflow'],
			'dateline'=>time()
		];
		$run_sign = (new Run())->mode->AddRunSing($data);
		if(!$run_sign){
            return  false;
        }
        return $run_sign;
    }
	static function EndRunSing($sing_sign,$check_con)
    {
       return (new Run())->mode->EndRunSing($sing_sign,$check_con);
    }
	
}