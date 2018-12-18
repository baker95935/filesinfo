<?php
namespace app\index\controller;
use think\Controller;

use think\Request;
use think\Session;
use app\admin\model\Count as countModel;

class Index extends Controller
{
 
	
    public function index()
    {
    	return view();
    }
    
     
}
