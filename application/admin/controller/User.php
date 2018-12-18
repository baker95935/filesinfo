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
		$search['username']=$request->param('username');
		$search['shop_id']=$request->param('shop_id');
		$search['shop_username']=$request->param('shop_username');
		$search['realname']=$request->param('realname');
		$search['phone']=$request->param('phone');
	 
		!empty($search['id']) && $where['id']=['=',$search['id']];
		!empty($search['username']) && $where['username']=['like',"%".$search['username']."%"];
		!empty($search['shop_id']) && $where['shop_id']=['like',"%".$search['shop_id']."%"];
		!empty($search['shop_username']) && $where['shop_username']=['like',"%".$search['shop_username']."%"];
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
				'username'=>$request->param('username'),
				'password'=>md5($request->param('password')),
				'confirmPassword'=>md5($request->param('confirmPassword')),
			
				'shop_id'=>$request->param('shop_id'),
				'shop_username'=>$request->param('shop_username'),
				'realname'=>$request->param('realname'),
				'phone'=>$request->param('phone'),
				'status'=>$request->param('status'),
			
				'id'=>$request->param('id'),
			);
			
			//数据校验
			$validate = validate('user');
			
			if(!$validate->check($data)){
				$this->error($validate->getError());
			
			} else {
				 
				unset($data['confirmPassword']);
				
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