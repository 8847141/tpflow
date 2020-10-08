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

//Tpflow 4.0工作流引擎路由配置
Route::group('wf', function () {
        Route::rule('welcome', '\workflow\Api@welcome');
        Route::rule('wfindex', '\workflow\Api@wfindex');
		Route::get('wfjk','\workflow\Api@wfjk');
		Route::rule('super_user','\workflow\Api@super_user');//获取用户信息
		Route::rule('super_role','\workflow\Api@super_role');//获取角色信息
		Route::rule('wfadd','\workflow\Api@wfadd');//工作流添加
		Route::rule('wfedit','\workflow\Api@wfedit');//工作流修改
		//流程设计器
		Route::get('wfdesc','\workflow\Api@wfdesc'); //设计界面
		Route::post('add_process','\workflow\Api@add_process'); //添加一个新流程
		Route::post('delete_process','\workflow\Api@delete_process'); //删除单个步骤
		Route::post('del_allprocess','\workflow\Api@del_allprocess'); //删除所有步骤
		Route::post('save_canvas','\workflow\Api@save_canvas'); //设计布局保存
		Route::get('wfchange','\workflow\Api@wfchange');//工作流启用关闭
		//步骤属性设计
		Route::get('wfatt','\workflow\Api@wfatt'); //设计界面
		Route::post('save_attribute','\workflow\Api@save_attribute'); //步骤属性保存
		Route::post('Checkflow','\workflow\Api@Checkflow'); //步骤属性保存
		//用户查询
		Route::post('super_get','\workflow\Api@super_get');//查询用户或者角色
		//流程启动  
		Route::get('wfcheck','\workflow\Api@wfcheck'); //发起工作流界面
		Route::get('wfstart','\workflow\Api@wfstart'); //发起工作流界面
		Route::post('statr_save','\workflow\Api@statr_save');//发起工作流保存
		Route::post('do_check_save','\workflow\Api@do_check_save');//审核保存
		Route::get('wfup','\workflow\Api@wfup'); //发起工作流界面
		Route::post('wfupsave','\workflow\Api@wfupsave');//审核保存
		Route::post('wfend','\workflow\Api@wfend');//终止工作流接口
		Route::post('ajax_back','\workflow\Api@ajax_back');//终止工作流接口
    });