<?php
namespace app\admin\controller;
use app\admin\model\User as userModel;
use think\Session;

//用户表
class User extends Common
{
	public function index()
	{
		$list=array();
		$users=new userModel();
		
		$request = request();
		$search['sex']=$request->param('sex');
		$search['username']=$request->param('username');
		$search['familyname']=$request->param('familyname');
		$search['birthday']=$request->param('birthday');
	 
		!empty($search['age']) && $where['age']=['=',$search['age']];
		!empty($search['username']) && $where['username']=['like',"%".$search['username']."%"];
		!empty($search['familyname']) && $where['familyname']=['like',"%".$search['familyname']."%"];
		!empty($search['birthday']) && $where['birthday']=['=',$search['birthday']];
		
		empty($where['id']) && $where['id']=['>',0];
		
		//登录用户的权限进行校验
		$group=Session::get('group');
		
		//增删改查校验
		$addRight=$listRight=0;
		$addRight=checkGroupRights($group,'useradd');
		$listRight=checkGroupRights($group,'userlist');
		
		
		$familyDelete=$familyEdit=$familyView=0;
		//4组权限判断
		$familyDelete=checkGroupRights($group,'userfamily-name-sex-birthday-delete');
		$familyEdit=checkGroupRights($group,'userfamily-name-sex-birthday-edit');
		$familyView=checkGroupRights($group,'userfamily-name-sex-birthday-view');
		$this->assign('familyDelete',$familyDelete);
		$this->assign('familyEdit',$familyEdit);
		$this->assign('familyView',$familyView);
		
		
		$countryDelete=$countryEdit=$countryView=0;
		$countryDelete=checkGroupRights($group,'usercountry-idcard-delete');
		$countryEdit=checkGroupRights($group,'usercountry-idcard-edit');
		$countryView=checkGroupRights($group,'usercountry-idcard-view');
		
		$this->assign('countryDelete',$countryDelete);
		$this->assign('countryEdit',$countryEdit);
		$this->assign('countryView',$countryView);
		
		$phoneDelete=$phoneEdit=$phoneView=0;
		$phoneDelete=checkGroupRights($group,'userphone-address-delete');
		$phoneEdit=checkGroupRights($group,'userphone-address-edit');
		$phoneView=checkGroupRights($group,'userphone-address-view');
		
		$this->assign('phoneDelete',$phoneDelete);
		$this->assign('phoneEdit',$phoneEdit);
		$this->assign('phoneView',$phoneView);
		
		$picDelete=$picEdit=$picView=0;
		$picDelete=checkGroupRights($group,'userpic-other-delete');
		$picEdit=checkGroupRights($group,'userpic-other-edit');
		$picView=checkGroupRights($group,'userpic-other-view');
		
		$this->assign('picDelete',$picDelete);
		$this->assign('picEdit',$picEdit);
		$this->assign('picView',$picView);
		
		
	 
		if($search['username'] || $listRight) {
			$list=$users->getListInfo($where,array('search'=>$search));
		}
		$this->assign('list',$list);
		$this->assign('search',$search);
		
		$this->assign('addRight',$addRight);
		
		return view();
	}

	public function add()
	{
		$user=new userModel();
		$request = request();
		
		$id=$request->param('id');
	 
		
		if($request->method()=='POST') {
			//数据获取
			$data=array(
				'familyname'=>$request->param('familyname'),
				'username'=>$request->param('username'),
				'age'=>$request->param('age'),
				'sex'=>$request->param('sex'),
				'birthday'=>$request->param('birthday'),
					
				'idcard'=>$request->param('idcard'),
				'country'=>$request->param('country'),
				'address'=>$request->param('address'),
				'contact'=>$request->param('contact'),
				'pic'=>$request->param('pic_url'),
				'beizhu'=>$request->param('beizhu'),
			
				'id'=>$request->param('id'),
			);
			
			//数据校验
			$validate = validate('user');
			
			if(!$validate->check($data)){
				$this->error($validate->getError());
			
			} else {
				 
				
				$result=0;
				if(empty($id)){//添加
					$data['create_time']=time();
					$result=$user->addInfo($data);
				} else {
					$result=$user->addInfo($data,array('id'=>$id));//更新
				}
				
				if($result) {
					$this->success('operation success', '/admin/user/index/');
				} else {
					$this->success('operation failed,please retry', '/admin/user/index/');
				}
			}
	
		}
			
		 
		return view();
	}
	

	public function edit()
	{
		$user=new userModel();
		$request = request();
	
		$id=$request->param('id');
	
	
		if($request->method()=='POST') {
			//数据获取
			$data=array(
					'familyname'=>$request->param('familyname'),
					'username'=>$request->param('username'),
					'age'=>$request->param('age'),
					'sex'=>$request->param('sex'),
					'birthday'=>$request->param('birthday'),
						
					'idcard'=>$request->param('idcard'),
					'country'=>$request->param('country'),
					'address'=>$request->param('address'),
					'contact'=>$request->param('contact'),
					'pic'=>$request->param('pic_url'),
					'beizhu'=>$request->param('beizhu'),
						
					'id'=>$request->param('id'),
			);
				
			//数据校验
			$validate = validate('user');
				
			if(!$validate->check($data)){
				$this->error($validate->getError());
					
			} else {
					
	
				$result=0;
				if(empty($id)){//添加
					$data['create_time']=time();
					$result=$user->addInfo($data);
				} else {
					$result=$user->addInfo($data,array('id'=>$id));//更新
				}
	
				if($result) {
					$this->success('operation success', '/admin/user/index/');
				} else {
					$this->success('operation failed,please retry', '/admin/user/index/');
				}
			}
	
		}
			
		$data=array();
		!empty($id) && $data=UserModel::get($id);
	
		$countryEdit=$familyEdit=$phoneEdit=$picEdit=0;
		//如果有数据 那么就是编辑 进行校验
		if(!empty($data)) {
				
			//登录用户的权限进行校验
			$group=Session::get('group');
			$countryEdit=checkGroupRights($group,'usercountry-idcard-edit');
			$familyEdit=checkGroupRights($group,'userfamily-name-sex-birthday-edit');
			$phoneEdit=checkGroupRights($group,'userphone-address-edit');
			$picEdit=checkGroupRights($group,'userpic-other-edit');
	
		}
	
		$this->assign('countryEdit',$countryEdit);
		$this->assign('familyEdit',$familyEdit);
		$this->assign('phoneEdit',$phoneEdit);
		$this->assign('picEdit',$picEdit);
	
		$this->assign('data',$data);
		return view();
	}
	
	public function del()
	{
		$user=new userModel();
		$request = request();
		
		if($request->method()=='GET') {
			
			$id=$request->param('id');
			$result=0;
			//$result=$user->deleteInfo($id);
			
			//登录用户的权限进行校验
			$group=Session::get('group');
			$countryDelete=checkGroupRights($group,'usercountry-idcard-delete');
			$familyDelete=checkGroupRights($group,'userfamily-name-sex-birthday-delete');
			$phoneDelete=checkGroupRights($group,'userphone-address-delete');
			$picDelete=checkGroupRights($group,'userpic-other-delete');
			
			$data=array();
			if($familyDelete==1) {
				$data['familyname']='';
				$data['username']='';
				$data['sex']=0;
				$data['birthday']=0;
			}
			
			if($countryDelete==1) {
				$data['country']='';
				$data['idcard']='';
			}
			
			if($phoneDelete==1) {
				$data['contact']='';
				$data['address']='';
			}
			
			if($picDelete==1) {
				$data['age']=0;
				$data['pic']='';
				$data['beizhu']='';
			}
			
			$result=$user->addInfo($data,array('id'=>$id));//更新
			
			if($result==0){
				$this->error('operation failed,please retry');
			} else {
				$this->success('operation success', '/admin/user/index/');
			}
		}
		
		$this->error('error,please retry');
	}
	
	public function show()
	{
		$information=new userModel();
		$request = request();
	
		$id=$request->param('id');
			
		$data=array();
		!empty($id) && $data=userModel::get($id);
		
		//登录用户的权限进行校验
		$group=Session::get('group');
		
		$countryView=$familyView=$phoneView=$picView=0;
		
		$countryView=checkGroupRights($group,'usercountry-idcard-view');
		$familyView=checkGroupRights($group,'userfamily-name-sex-birthday-view');
		$phoneView=checkGroupRights($group,'userphone-address-view');
		$picView=checkGroupRights($group,'userpic-other-view');
		
		$this->assign('countryView',$countryView);
		$this->assign('familyView',$familyView);
		$this->assign('phoneView',$phoneView);
		$this->assign('picView',$picView);
		
		$this->assign('data',$data);
		return view();
	}
}