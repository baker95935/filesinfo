<?php
namespace app\admin\controller;
use app\admin\model\Member as memberModel;
use think\Controller;
use think\Session;

//登录页面
class Login extends Controller 
{
	public function Login()
	{
		$member=new memberModel();
		$request = request();
		$data=array();
		
		if($request->method()=='POST') {
			$data['username']=$request->param('username');
			$data['password']=md5($request->param('password'));
		 
			$result=$member->validLogin($data);
			
			if($result) {
				$this->success('login success!', '/admin/index/index/');
			} 
			$this->error('login failure，please retry');
			
		}
		
		return view();
	}
	
	public function Logout()
	{
		Session::delete('username');
		Session::delete('password');
		
		Session::clear();
		$this->success('logout success!', '/admin/login/login/');
		
	}
	
}