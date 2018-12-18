<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

return [
    '__pattern__' => [
        'name' => '\w+',
    ],
    '[hello]'     => [
        ':id'   => ['index/hello', ['method' => 'get'], ['id' => '\d+']],
        ':name' => ['index/hello', ['method' => 'post']],
    ],

    '[admin]'     => [
	    'index'=>['admin/index/index'],
	    
	    'login/login'=>['admin/login/login'],
	    'login/logout'=>['admin/login/logout'],
	    
	    'information/index'=>['admin/information/index'],
	    'information/add'=>['admin/information/add'],
	     
	    'user/index'=>['admin/user/index'],
	    'user/add'=>['admin/user/add'],
	    
	    'member/index'=>['admin/member/index'],
	    'member/add'=>['admin/member/add'],
 
	     
	    'brand/index'=>['admin/brand/index'],
	    'brand/add'=>['admin/brand/add'],
	    
	    'count/index'=>['admin/count/index'],
    ],
    '[index]'     => [
	    'login/login'=>['index/login/login'],
		'login/logout'=>['index/login/logout'],
    ]
];
