<?php
namespace app\index\model;

use think\Model;
use think\Session;
use app\admin\model\Count as countModel;


class User extends Model
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
		$list = User::where($where)->order('id desc')->paginate(array('list_rows'=>20,'query'=>$query)); // 分页的url额外参数);
		return $list;
	}
	
	//密码找回使用
	public function getUserInfoByUsername($username)
	{
		$result=array();
		return $result=User::where('username','=',$username)->find();
	}
	
	//验证登录
	public function validLogin($data) 
	{
		//逻辑思路处理，根据用户名找密码
		$result=0;

		if(!empty($data['username']) && !empty($data['password']))
		{
			$dataInfo=User::where('username','=',$data['username'])->find();
			if($data['password']==$dataInfo->password) 
			{
				Session::set('username',$dataInfo->username);
				Session::set('password',md5($dataInfo->id.$dataInfo->password));
				
				//登录成功之后 写入登录日志
				$data=array(
					'username'=>$dataInfo->username,
				    'ipaddr'=>getIp(),
					'start_time'=>time(),
					'status'=>1,
					'create_time'=>time(),
					'user_id'=>$dataInfo->id,
				);
				$count=new countModel();
				$count->addInfo($data);
				$countId=$count->id;
				$countId >0 && Session::set('countId',$countId);
				
				$result=1;
			}
		}
		
		return $result;
	 
	}

}