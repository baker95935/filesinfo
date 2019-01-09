<?php

namespace app\admin\controller;

use app\admin\controller\Common;
use think\Request;
use app\admin\model\Group as groupModel;
//管理组
class Group extends Common
{
    public function index()
	{
		$list=array();
		$groups=new groupModel();
		
		$request = request();
		$search=$request->param('search');
	 
		!empty($search) && $where['username']=['like',"%".$search."%"];
		$where['id']=['>',0];
		
		$list=$groups->getListInfo($where,array('search'=>$search));
		$this->assign('list',$list);
		$this->assign('search',$search);
 
		return view();
	}

	public function add()
	{
		$group=new groupModel();
		$request = request();
		
		$id=$request->param('id');
	 
		if($request->method()=='POST') {
			//数据获取
			$data=array(
				'name'=>$request->param('groupname'),
				'remark'=>$request->param('remark'),
				'id'=>$request->param('id'),
				'super'=>$request->param('super'),
			);
			
			//如果不是超级权限获取列表
			if($data['super']!=1) {
				$vars=$request->param();
				isset($vars['type']) && $type=$vars['type'];
				isset($vars['node']) && $node=$vars['node'];
					
				//数组变成字符串
				if(!empty($type)){
					$typeStr=implode(",",$type);
					$data['type']=$typeStr;
				}
			
				if(!empty($node)){
					$nodeStr=implode(",",$node);
					$data['node']=$nodeStr;
				}
			
			}
			
				
			$result=0;
			if(empty($id)){//添加
				$data['create_time']=time();
				$result=$group->addInfo($data);
			} else {
				$result=$group->addInfo($data,array('id'=>$id));//更新
			}
			
			if($result) {
				$this->success('operation success!', '/admin/group/index/');
			} else {
				$this->success('operation failed,please retry', '/admin/group/index/');
			}
	
		}
			
		$data=array();
		!empty($id) && $data=groupModel::get($id);
 
		//权限列表搞成数组容易实现
		if($data && $data['super']==2) {
			!empty($data['type']) && $data['typeAry']=explode(',',$data['type']);
			!empty($data['node']) && $data['nodeAry']=explode(',',$data['node']);
		}
		
		//获取权限
		$menuList=array(
				//'files'=>array('add','delete','edit','view'),
				'user'=>array('add','delete','edit','view'),
		);
		
		//设置默认显示的权限
		$defaultRight=1;
		!empty($data) && $defaultRight=$data['super'];
		$this->assign('defaultRight',$defaultRight);
		
		$this->assign('menuList',$menuList);
		$this->assign('data',$data);
		return view();
	}
	
	public function del()
	{
		$user=new groupModel();
		$request = request();
		
		if($request->method()=='GET') {
			
			$id=$request->param('id');
			$result=0;
			$result=$user->deleteInfo($id);
			
			if($result==0){
				$this->error('operation failed,please retry');
			} else {
				$this->success('operation success', '/admin/member/index/');
			}
		}
		
		$this->error('error,please retry');
	}
}
