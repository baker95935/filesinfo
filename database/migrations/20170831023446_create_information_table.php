<?php

use think\migration\Migrator;
use think\migration\db\Column;

class CreateInformationTable extends Migrator
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
	  $this->table('information',['engine'=>'MyISAM'])
	    ->addColumn(Column::string('name')->setUnique()->setComment('名称'))
	    ->addColumn(Column::string('location')->setComment('位置'))
	    ->addColumn(Column::string('car_model')->setComment('车型'))
	    
	    ->addColumn(Column::string('iid')->setComment('ID'))
	    ->addColumn(Column::integer('status')->setComment('状态'))
	    ->addColumn(Column::integer('create_time')->setComment('添加时间'))
	    ->create();
	}
	
	/**
	* Down Method.
	*/
	public function down()
	{
	    $this->dropTable('information');
	}
}
