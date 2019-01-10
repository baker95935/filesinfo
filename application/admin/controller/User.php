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
		$addRight=$editRight=$deleteRight=$viewRight=0;
		$addRight=checkGroupRights($group,'useradd');
		$editRight=checkGroupRights($group,'useredit');
		$deleteRight=checkGroupRights($group,'userdelete');
		$viewRight=checkGroupRights($group,'userview');
		$listRight=checkGroupRights($group,'userlist');
	 
		if($search['username'] || $listRight) {
			$list=$users->getListInfo($where,array('search'=>$search));
		}
		$this->assign('list',$list);
		$this->assign('search',$search);
		
		$this->assign('addRight',$addRight);
		$this->assign('editRight',$editRight);
		$this->assign('deleteRight',$deleteRight);
		$this->assign('viewRight',$viewRight);
		
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
			
		$data=array();
		!empty($id) && $data=UserModel::get($id);
 
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
			$result=$user->deleteInfo($id);
			
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
	
		$this->assign('data',$data);
		return view();
	}
}