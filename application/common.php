<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件

function getStatusName($status)
{
	$name="";
	
	$status==1?$name='启用':$name="禁用";
	
	return $name;
}

//字符串截取函数
function msubstr($str, $start=0, $length, $charset="utf-8", $suffix=false){
 if(function_exists("mb_substr")){
 if($suffix)
 return mb_substr($str, $start, $length, $charset)."...";
 else
 return mb_substr($str, $start, $length, $charset);
 }elseif(function_exists('iconv_substr')) {
 if($suffix)
 return iconv_substr($str,$start,$length,$charset)."...";
 else
 return iconv_substr($str,$start,$length,$charset);
 }
 $re['utf-8'] = "/[x01-x7f]|[xc2-xdf][x80-xbf]|[xe0-xef][x80-xbf]{2}|[xf0-xff][x80-xbf]{3}/";
 $re['gb2312'] = "/[x01-x7f]|[xb0-xf7][xa0-xfe]/";
 $re['gbk'] = "/[x01-x7f]|[x81-xfe][x40-xfe]/";
 $re['big5'] = "/[x01-x7f]|[x81-xfe]([x40-x7e]|xa1-xfe])/";
 preg_match_all($re[$charset], $str, $match);
 $slice = join("",array_slice($match[0], $start, $length));
 if($suffix) return $slice."…";
 return $slice;
}

function onlineTime($start_time,$end_time)
{
	$result=$res=0;
	
	if(!empty($start_time) && !empty($end_time)) {
		$res=$end_time-$start_time;
		$f=array(
	        '31536000'=>'年',
	        '2592000'=>'个月',
	        '604800'=>'星期',
	        '86400'=>'天',
	        '3600'=>'小时',
	        '60'=>'分钟',
	        '1'=>'秒',
    	);
 
    	foreach($f as $k=>$v){
	        if (0 !=$c=floor($res/(int)$k)) {
	            return  $c.'&nbsp;'.$v;
	        }
    	}	
		
	}
	
	return $result;
}


 function getIp()
    {

        if(!empty($_SERVER["HTTP_CLIENT_IP"]))
        {
            $cip = $_SERVER["HTTP_CLIENT_IP"];
        }
        else if(!empty($_SERVER["HTTP_X_FORWARDED_FOR"]))
        {
            $cip = $_SERVER["HTTP_X_FORWARDED_FOR"];
        }
        else if(!empty($_SERVER["REMOTE_ADDR"]))
        {
            $cip = $_SERVER["REMOTE_ADDR"];
        }
        else
        {
            $cip = '';
        }
        preg_match("/[\d\.]{7,15}/", $cip, $cips);
        $cip = isset($cips[0]) ? $cips[0] : 'unknown';
        unset($cips);

        return $cip;
    }
    
    
    //获取场景的ID
    function getSceneNameById($id)
    {
     	$res='其他';
    	$scene=model('Scene');
    	$tmp=$scene->find($id);
    	!empty($tmp['name']) && $res=$tmp['name'];
     
    	return $res;
    }
    

    //获取福袋的名称
    function getLuckybagNameById($id)
    {
    	$res='空';
    	if($id) {
	    	$luckybag=model('Luckybag');
	    	$tmp=$luckybag->find($id);
	    	!empty($tmp) && $res=$tmp['name'];
    	}
    	return $res;
    }