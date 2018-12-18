<?php

namespace app\admin\controller;

use app\admin\controller\Common;
use think\Request;
use app\admin\model\Information as informationModel;
use app\admin\model\InformationExtend as infoEModel;
use think\File;
//信息
class Information extends Common
{
     public function index()
	{
		$list=array();
		$information=new informationModel();
		
		$request = request();
		$search=$request->param('search');
	 
		!empty($search) && $where['name']=['like',"%".$search."%"];
		$where['id']=['>',0];
		
		$list=$information->getListInfo($where,array('search'=>$search));
 
		$this->assign('list',$list);
		$this->assign('search',$search);
		
		return view();
	}

	public function add()
	{
		$information=new informationModel();
		$request = request();
		
		$id=$request->param('id');
	 
		if($request->method()=='POST') {
			//数据获取
			$data=array(
				'name'=>$request->param('name'),
				'location'=>$request->param('location'),
				'car_model'=>$request->param('car_model'),
				'status'=>$request->param('status'),
				'iid'=>$request->param('iid'),
			);
			
			//数据校验
			$validate = 0;
			
			if($validate){
				$this->error($validate->getError());
			
			} else {
				 
				
				$result=0;
				if(empty($id)){//添加
					$data['create_time']=time();
					$result=$information->addInfo($data);
				} else {
					$result=$information->addInfo($data,array('id'=>$id));//更新
				}
				
				if($result) {
					$this->success('operation success!', '/admin/information/index/');
				} else {
					$this->success('operation failed', '/admin/information/index/');
				}
			}
	
		}
			
		$data=array();
		!empty($id) && $data=informationModel::get($id);
 
		$this->assign('data',$data);
		return view();
	}
	
	public function edit()
	{
		$information=new informationModel();
		$infoE=new infoEModel();
		$request = request();
		
		$id=$request->param('id');
		
		if($request->method()=='POST') {
			
			//数据获取
			$data=array(
				'name'=>$request->param('name'),
				'location'=>$request->param('location'),
				'car_model'=>$request->param('car_model'),
				'status'=>$request->param('status'),
				'iid'=>$request->param('iid'),
				'id'=>$request->param('id'),
			);
			
			//多组数据上传
			$length=$request->param('divCount');
			$dbdata=array();
			for($i=0;$i<$length;$i++) {
				//图片上传
				$ndata=array();
				$file = $request->file('pic'.$i);
				!empty($file) && $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
				if(!empty($info)){
			        $filepath="uploads/".$info->getSaveName();
			        
			        $dbdata[$i]=array(
			        		'title'=>$request->param('title'.$i),
			        		'content'=>$request->param('content'.$i),
			        		'pic'=>$filepath,
			        		'iid'=>$data['id'],
			        		'create_time'=>time(),
			        );
			    }
				
			}
			!empty($dbdata) && $infoE->saveAll($dbdata);//数据存储
			
			$result=$information->addInfo($data,array('id'=>$id));//更新
			
			if($result) {
				$this->success('operation success!', '/admin/information/index/');
			} else {
				$this->success('operation failed', '/admin/information/index/');
			}
			 
		}
		
		$data=$hotList=array();
		!empty($id) && $data=informationModel::get($id);
		$hotList=$infoE->getListInfo(array('iid'=>$data['id']),array());
	 
		$this->assign('hotList',$hotList);
		$this->assign('data',$data);
		return view();
	}
	
	public function del()
	{
		$information=new informationModel();
		$request = request();
		
		if($request->method()=='GET') {
			
			$id=$request->param('id');
			$result=0;
			$result=$information->deleteInfo($id);
			
			if($result==0){
				$this->error('operation failed,please retry');
			} else {
				$this->success('operation success!', '/admin/information/index/');
			}
		}
		
		$this->error('error,please retry');
	}
	
	public function delE()
	{
		$infoE=new infoEModel();
		$request = request();
		
		if($request->method()=='GET') {
			
			$id=$request->param('id');
			$iid=$request->param('iid');
			$result=0;
			$result=$infoE->deleteInfo($id);
			
			if($result==0){
				$this->error('operation failed,please retry');
			} else {
				$this->success('operation success', '/admin/information/edit/id/'.$iid);
			}
		}
		
		$this->error('error,please retry');
	}
}
