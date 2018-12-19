<?php
namespace app\admin\validate;

use think\Validate;

class User extends Validate
{
	protected $rule = [
		'username'  =>  'require|max:30|unique:user',
		'__token__' => 'token',
	];

}