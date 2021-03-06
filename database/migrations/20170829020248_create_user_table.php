<?php

use think\migration\Migrator;
use think\migration\db\Column;

class CreateUserTable extends Migrator
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     *
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     *    createTable
     *    renameTable
     *    addColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
	public function up()
	{
	  $this->table('user',['engine'=>'MyISAM'])
	    ->addColumn(Column::string('username')->setUnique()->setComment('用户名'))
	    ->addColumn(Column::string('password')->setComment('密码'))
	    ->addColumn(Column::string('shop_id')->setComment('商城ID'))
	    ->addColumn(Column::string('shop_username')->setComment('商城用户名'))
	    ->addColumn(Column::string('realname')->setComment('真实姓名'))
	    ->addColumn(Column::string('phone')->setComment('电话'))
	    ->addColumn(Column::integer('status')->setComment('状态'))
	    ->addColumn(Column::integer('create_time')->setComment('添加时间'))
	    ->create();
	}
	
	/**
	* Down Method.
	*/
	public function down()
	{
	    $this->dropTable('user');
	}
}
