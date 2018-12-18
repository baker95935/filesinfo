<?php

use think\migration\Seeder;
use app\admin\model\Member;


class CreateUserTable extends Seeder
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * http://docs.phinx.org/en/latest/seeding.html
     */
    public function run()
    {
   
		Member::create([
    		'username'   => 'admin',
    		'password'   => md5("adminadmin"),
    		'status'=>1,
    		'create_time'=>time(),
		]);
   
    }
}