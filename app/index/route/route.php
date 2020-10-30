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
        Route::rule('welcome', '\tpflow\Api@welcome');
        Route::rule('wfindex', '\tpflow\Api@wfindex');
		Route::get('wfjk','\tpflow\Api@wfjk');
		Route::rule('super_user','\tpflow\Api@super_user');//获取用户信息/角色信息查询接口
		Route::rule('wfadd','\tpflow\Api@wfadd');//工作流添加\修改
		Route::rule('entrust','\tpflow\Api@entrust'); //代理授权接口
		//流程设计器
		Route::get('wfdesc','\tpflow\Api@wfdesc'); //设计界面
		Route::post('add_process','\tpflow\Api@add_process'); //添加一个新流程
		Route::post('delete_process','\tpflow\Api@delete_process'); //删除单个步骤
		Route::post('del_allprocess','\tpflow\Api@del_allprocess'); //删除所有步骤
		Route::post('save_canvas','\tpflow\Api@save_canvas'); //设计布局保存
		Route::get('wfchange','\tpflow\Api@wfchange');//工作流启用关闭
		//步骤属性设计
		Route::get('wfatt','\tpflow\Api@wfatt'); //设计界面
		Route::post('save_attribute','\tpflow\Api@save_attribute'); //步骤属性保存
		Route::post('Checkflow','\tpflow\Api@Checkflow'); //步骤属性保存
		//流程启动  
		Route::rule('wfcheck','\tpflow\Api@wfcheck'); //工作流审核
		Route::rule('wfstart','\tpflow\Api@wfstart'); //发起工作流界面
		Route::post('do_check_save','\tpflow\Api@do_check_save');//审核保存
		Route::rule('wfup','\tpflow\Api@wfup'); //发起工作流界面
		Route::post('wfend','\tpflow\Api@wfend');//终止工作流接口
		Route::post('ajax_back','\tpflow\Api@ajax_back');//终止工作流接口
		Route::get('wfgl','\tpflow\Api@wfgl'); //
		
		
    });