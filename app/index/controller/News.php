<?php
/*
 * 公司新闻模块
 * @2018年1月21日
 * @Gwb
 */

namespace app\index\controller;

use app\Basec;
use think\Request;
use think\facade\View;
use think\facade\Db;

class News extends Basec
{
    /**
     * 新闻列表
     */
    public function index($map=[])
    {
       if ($this->request->param("new_title")) $map[] = ['new_title','like',"%" . $this->request->param("new_title") . "%"];
	   $model=new \app\index\event\Base;
        $list=$model->commonlist('news',$map);
		View::assign('list', $list);
		return View::fetch();
    }

    /**
     * 新增新闻
     */
    public function add()
    {
		if ($this->request->isPost()) {
		$data = input('post.');
		$model=new \app\index\event\Base;
		$ret=$model->commonadd('news',$data);
	    if($ret['code']==0){
			return msg_return('发布成功！');
			}else{
			return msg_return($ret['data'],1);
		}
	   }
	   View::assign('type', Db::name('news_type')->select());
        return View::fetch();
    }
	/**
     * 查看新闻
     */
    public function view()
    {
		$info = Db::name('news')->find(input('id'));
		 View::assign('info', $info);
        return View::fetch();
    }
	/**
     * 修改新闻
     */
    public function edit()
    {
        if ($this->request->isPost()) {
		$data = input('post.');
		$data['status'] = 0;
		$model=new \app\index\event\Base;
		$ret=$model->commonedit('news',$data);
		if($ret['code']==0){
			return msg_return('修改成功！');
			}else{
			return msg_return($ret['data'],1);
		}
	   }
	   if(input('id')){
		 $info = Db::name('news')->find(input('id'));
		  View::assign('info', $info);
		   View::assign('type', Db::name('news_type')->select());
	   }
	   return View::fetch('add');
    }

}
