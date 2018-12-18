<?php

namespace app\index\controller;

use think\Controller;
use think\Request;
use app\admin\model\Information as informationModel;
use app\admin\model\InformationExtend as infoEModel;
use app\admin\model\Brand as brandModel;
use app\admin\model\Count as countModel;

use app\admin\model\Scene as SceneModel;
use app\admin\model\Luckybag as LuckybagModel;
use app\admin\model\Luckybagcount as LuckybagcountModel;

use think\Config;

class Api extends Controller
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        //
    }

    /**
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function information()
    {
        $information=new informationModel();
		$infoE=new infoEModel();
		$request = request();
		
		$result=array();
		
		$id=$request->param('id');
		if(!empty($id)) {
	    	$data=$hotList=array();
			$data=informationModel::get($id);
			$tmp=$infoE->getList(array('iid'=>$data['id']));
			!empty($tmp) && $data['extends']=$tmp;
		}
		return jsonp($data);
    }

    
    public function brand()
    {
        $brand=new brandModel();
        $request = request();
        
        $result=array();
        
        $id=$request->param('id');
        if(!empty($id)) {
            $data=array();
            $data=brandModel::get($id);
            $data['video1pic']= Config::get('view_replace_str.__ROOT__').$data['video1pic'];
            $data['video2pic']= Config::get('view_replace_str.__ROOT__').$data['video2pic'];
            $data['video3pic']= Config::get('view_replace_str.__ROOT__').$data['video3pic'];
        }
        return jsonp($data);
    }
    
    public function count()
    {
    	$count=new countModel();
        $request = request();
        
        $result=array();
        $result['code']=0;
        $data=array();
 
    	$data=array(
			'ipaddr'=>$request->param('ipaddr'),
			'start_time'=>$request->param('start_time'),
			'username'=>$request->param('username'),
		);
		
		if(!empty($data['ipaddr']) && $data['start_time']) {
			$data['status']=1;
			$data['create_time']=time();
			$count->addInfo($data);
			$countId=$count->id;
			$result['code']=1;
			$result['countId']=$countId;
		}
		return jsonp($result);
    }
    
    //场景详情
    public function scene()
    {
    	$scene=new SceneModel();
    	$request = request();
    	
    	$id=$request->param('id');
        if(!empty($id)) {
            $data=array();
            $data=$scene->find($id);
        }
        return jsonp($data);
    }
    
    //福袋信息获取
    public function luckybag()
    {
    	$bag=new LuckybagModel();
    	$request = request();
    	
    	$id=$request->param('id');
        if(!empty($id)) {
            $data=array();
             $data=$bag->find($id);
            $data['pic']= Config::get('view_replace_str.__ROOT__').$data['pic'];
        }
        return jsonp($data);
    }
    
    //福袋数据统计
    public function luckybagcount()
    {
    	$count=new LuckybagcountModel();
        $request = request();
        
        $result=array();
        $result['code']=0;
        $data=array();
 
    	$data=array(
			'ipaddr'=>$request->param('ipaddr'),
			'scene_id'=>$request->param('scene_id'),
			'luckybag_id'=>$request->param('luckybag_id'),
			'luckybag_click'=>$request->param('luckybag_click'),
			'adviser_click'=>$request->param('adviser_click'),
			'testdrive_click'=>$request->param('testdrive_click'),
			'buy_click'=>$request->param('buy_click'),
			'activity_click'=>$request->param('activity_click'),
			'finance_click'=>$request->param('finance_click'),
			'substitution_click'=>$request->param('substitution_click'),
            'service_click'=>$request->param('service_click'),
		);
		
		empty($data['scene_id']) && $data['scene_id']=0;
		empty($data['luckybag_click']) && $data['luckybag_click']=0;
		empty($data['adviser_click']) && $data['adviser_click']=0;
		empty($data['testdrive_click']) && $data['testdrive_click']=0;
		empty($data['buy_click']) && $data['buy_click']=0;
		empty($data['activity_click']) && $data['activity_click']=0;
		empty($data['finance_click']) && $data['finance_click']=0;
		empty($data['substitution_click']) && $data['substitution_click']=0;
        empty($data['luckybag_id']) && $data['luckybag_id']=0;
        empty($data['service_click']) && $data['service_click']=0;
		
		
		if(!empty($data['ipaddr'])) {
			$data['create_time']=time();
			$count->addInfo($data);
			$countId=$count->id;
			$result['code']=1;
			$result['countId']=$countId;
		}
		return jsonp($result);
    } 
}
