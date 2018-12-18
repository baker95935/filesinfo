<?php

use think\migration\Migrator;
use think\migration\db\Column;

class CreateCountTable extends Migrator
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
	  $this->table('count',['engine'=>'MyISAM'])
	    ->addColumn(Column::string('username')->setComment('用户名'))
	    ->addColumn(Column::string('ipaddr')->setComment('IP地址'))
	    ->addColumn(Column::integer('start_time')->setComment('访问开始时间'))
	    ->addColumn(Column::integer('end_time')->setComment('结束时间')) 
	    ->addColumn(Column::integer('online_time')->setComment('在线时长')) 
	    ->addColumn(Column::integer('user_id')->setComment('用户ID')) 
 		->addColumn(Column::integer('status')->setComment('状态'))
 	    ->addColumn(Column::integer('create_time')->setComment('添加时间'))
	    ->create();
	}
	
	/**
	* Down Method.
	*/
	public function down()
	{
	    $this->dropTable('information_extend');
	}
}
