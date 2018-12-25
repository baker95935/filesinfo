<?php

namespace app\admin\model;

use think\Model;

class Group extends Model
{
	//新增,更新
	public function addInfo($data,$where=array())
	{
		$result=0;
		!empty($data) && $result=$this->save($data,$where);
		return $result;
	}
	
	//删除
	public	function deleteInfo($id)
	{
		$result=0;
		$id && $result=$this->destroy($id);
		
		return $result;
	}
	
	//列表
	public function getListInfo($where,$query)
	{
		$list=array();
		$list = Group::where($where)->order('id desc')->paginate(array('list_rows'=>20,'query'=>$query)); // 分页的url额外参数);
		return $list;
	}
	
	 
}
