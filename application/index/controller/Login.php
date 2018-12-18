<?php

namespace app\index\controller;

use think\response\Redirect;

use think\Controller;
use think\Request;
use think\Session;

use app\index\model\User as userModel;
use app\admin\model\Count as countModel;

class Login extends Controller
{
     public function login()
     {
     	$user=new userModel();
		$request = request();
		$data=array();
		
		if($request->method()=='POST') {
			$data['username']=$request->param('username');
			$data['password']=md5($request->param('password'));
		 
			$result=$user->validLogin($data);
			
			if($result) {
				$this->success('登录成功', '/index/index/index/');
			} 
			$this->error('登录失败，请重试');
			
		}
     	return view();
     }
     
     public function forget()
     {
     	$user=new userModel();
		$request = request();
		$data=array();
		
     	if($request->method()=='POST') {
			$data=array(
				'username'=>$request->param('username'),
				'password'=>md5($request->param('password')),
				'confirmPassword'=>md5($request->param('confirmPassword')),
			
			);
			
			//数据校验
			$captcha=$request->param('captcha');
			
			$result=0;
			
			if(!captcha_check($captcha)){
				$this->error('验证码错误');
			
			} else {
				$userInfo=$user->getUserInfoByUsername($data['username']);
				if(!empty($userInfo)) {
					unset($data['confirmPassword']);
					$result=$user->addInfo($data,array('id'=>$userInfo->id));//更新
				} else {
					$this->error('用户名不存在，请重试');
				}
			}
			
			if($result) {
				$this->success('修改成功！', '/index/index/index/');
			} 
			$this->error('登录失败，请重试');
			
		}
		
     	return view();
     }
     
     public function logout()
     {
     	$countId=Session::get('countId');
     	
     	if($countId) {
     		$data['end_time']=time();
     		$data['is_click']=1;
     		$count=new countModel();
     		$count->addInfo($data,array('id'=>$countId));
     	}
     	
     	Session::delete('username');
		Session::delete('password');
		
		Session::clear();
		$this->redirect('http://www.jd.com');
     	//退出登录，记载时间然后跳转
     }
     
     public function register()
     {
     	$user=new userModel();
		$request = request();
		
	 
		if($request->method()=='POST') {
			//数据获取
			$data=array(
				'username'=>$request->param('username'),
				'password'=>md5($request->param('password')),
				'confirmPassword'=>md5($request->param('confirmPassword')),
			
			);
			
			//数据校验
			$captcha=$request->param('captcha');
			
			if(!captcha_check($captcha)){
				$this->error('验证码错误');
			
			} else {
				 
				unset($data['confirmPassword']);
				$data['create_time']=time();
				$result=0;
				$result=$user->addInfo($data);
 
				
				if($result) {
					$this->success('操作成功', '/index/index/index/');
				} else {
					$this->success('操作失败或未生效请重试', '/index/index/index/');
				}
			}
		}
     	return view();
     }

public function test(){
	echo phpinfo();
}
}
