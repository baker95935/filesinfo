<?php
namespace app\admin\controller;
use think\Controller;
use think\Request;
use think\Session;
 


class Common extends Controller
{
	public function _initialize()
	{
		$request = Request::instance();
		
		//左侧导航条
		$nav=$request->controller();
		$this->assign('nav',$nav);
	 
		//登录校验
		if(!Session::has('username') || !Session::has('password') )
		{
			$this->redirect('/admin/login/login/');
		}
		
	}

}