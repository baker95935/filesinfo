<?php
namespace app\index\validate;

use think\Validate;

class User extends Validate
{
	protected $rule = [
		'username'  =>  'require|max:30|unique:user',
		'password' => 'require',
		'confirmPassword' =>  "require|confirm:password",
		'__token__' => 'token',
	];

}