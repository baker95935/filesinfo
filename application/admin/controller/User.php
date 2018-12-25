<?php
namespace app\admin\controller;
use app\admin\model\User as userModel;

//用户表
class User extends Common
{
	public function index()
	{
		$list=array();
		$users=new userModel();
		
		$request = request();
		$search['id']=$request->param('id');
		//$search['username']=$request->param('username');
		$search['realname']=$request->param('realname');
		$search['phone']=$request->param('phone');
	 
		!empty($search['id']) && $where['id']=['=',$search['id']];
		//!empty($search['username']) && $where['username']=['like',"%".$search['username']."%"];
		!empty($search['realname']) && $where['realname']=['like',"%".$search['realname']."%"];
		!empty($search['phone']) && $where['phone']=['like',"%".$search['phone']."%"];
		
		empty($where['id']) && $where['id']=['>',0];
		
		$list=$users->getListInfo($where,array('search'=>$search));
		$this->assign('list',$list);
		$this->assign('search',$search);
		
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
}