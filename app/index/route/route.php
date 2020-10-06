<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
use think\facade\Route;

Route::get('wf/welcome','\workflow\Api@welcome');
//列表
Route::get('wf/wfindex','\workflow\Api@wfindex');
Route::get('wf/wfjk','\workflow\Api@wfjk');
Route::get('wf/super_user','\workflow\Api@super_user');//获取用户信息
Route::get('wf/super_role','\workflow\Api@super_role');//获取角色信息

//工作流添加
Route::get('wf/wfadd','\workflow\Api@wfadd');
Route::post('wf/wfadd','\workflow\Api@wfadd');
//工作流修改
Route::get('wf/wfedit/id/:id','\workflow\Api@wfedit');
Route::post('wf/wfedit/id/:id','\workflow\Api@wfedit');
//流程设计器
Route::get('wf/wfdesc/flow_id/:flow_id','\workflow\Api@wfdesc'); //设计界面
Route::post('wf/add_process','\workflow\Api@add_process'); //添加一个新流程
Route::post('wf/delete_process','\workflow\Api@delete_process'); //删除单个步骤
Route::post('wf/del_allprocess','\workflow\Api@del_allprocess'); //删除所有步骤
Route::post('wf/save_canvas','\workflow\Api@save_canvas'); //设计布局保存
Route::get('wf/wfchange','\workflow\Api@wfchange');//工作流启用关闭

//步骤属性设计
Route::get('wf/wfatt','\workflow\Api@wfatt'); //设计界面
Route::post('wf/save_attribute','\workflow\Api@save_attribute'); //步骤属性保存
Route::post('wf/Checkflow','\workflow\Api@Checkflow'); //步骤属性保存

//用户查询
Route::post('wf/super_get','\workflow\Api@super_get');//查询用户或者角色

//流程启动  

Route::get('wf/wfcheck','\workflow\Api@wfcheck'); //发起工作流界面
Route::get('wf/wfstart','\workflow\Api@wfstart'); //发起工作流界面
Route::post('wf/statr_save','\workflow\Api@statr_save');//发起工作流保存
Route::post('wf/do_check_save','\workflow\Api@do_check_save');//审核保存
//附件接口

Route::get('wf/wfup','\workflow\Api@wfup'); //发起工作流界面
Route::post('wf/wfupsave','\workflow\Api@wfupsave');//审核保存
Route::post('wf/wfend','\workflow\Api@wfend');//终止工作流接口
Route::post('wf/ajax_back','\workflow\Api@ajax_back');//终止工作流接口
