<?php
namespace app\admin\validate;

use think\Validate;

class Member extends Validate
{
	protected $rule = [
		'username'  =>  'require|max:30|unique:user',
		'password' => 'require',
		'confirmPassword' =>  "require|confirm:password",
		'phone' => 'require',
		'realname' => 'require',
		'__token__' => 'token',
	];

}