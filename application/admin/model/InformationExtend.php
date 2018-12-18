<?php

namespace app\admin\model;

use think\Model;
use think\Config;

class InformationExtend extends Model
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
		$list = InformationExtend::where($where)->order('id desc')->paginate(array('list_rows'=>20,'query'=>$query)); // 分页的url额外参数);
 
		return $list;
	}
	
	//列表无分页
	public function getList($where)
	{
		$list=array();
	 
		$list = InformationExtend::where($where)->order('id desc')->select();  
		foreach($list as $k=>&$v) {
			!empty($v['pic']) && $v['pic']= Config::get('view_replace_str.__ROOT__').$v['pic'];
		}
		return $list;
	}
}
