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
		
		$rights='';
		//左侧权限校验
		$group=Session::get('group');
 
		$groupInfo=model('group')->find($group);
		if($groupInfo['super']==1) {
			$rights='all';
		} else {
			!empty($groupInfo['type']) && $rights=explode(',',$groupInfo['type']);
		}
		 
		$this->assign('rights',$rights);
	}

}