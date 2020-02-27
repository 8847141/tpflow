<?php
// 本类由系统自动生成，仅供测试用途
namespace app\index\Controller;
use app\BaseController;
use think\facade\Session;
use workflow\workflow;
use think\facade\View;
use think\facade\Db;

class Index  extends BaseController{
    public function index(){
		
	 View::assign('user',Db::name('user')->field('id,username,role')->select());
     return View::fetch();
    }
	public function welcome(){
	   View::assign('user',Db::name('user')->field('id,username,role')->select());
      return  View::fetch();
    }
	public function doc(){
      return  View::fetch();
    }
	public function login(){
		Session::clear();
		$info = Db::name('user')->find(input('id'));
        Session::set('uid', $info['id']);
		Session::set('uname', $info['username']);
		Session::set('role', $info['role']);
		echo 'success';
	}
}