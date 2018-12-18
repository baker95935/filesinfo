<?php

use think\migration\Migrator;
use think\migration\db\Column;

class CreateInfomationExtendTable extends Migrator
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
	  $this->table('information_extend',['engine'=>'MyISAM'])
	    ->addColumn(Column::string('title')->setComment('热点标题'))
	    ->addColumn(Column::string('pic')->setComment('图片'))
	    ->addColumn(Column::text('content')->setComment('信息内容'))
	    
	    ->addColumn(Column::string('iid')->setComment('info表ID'))
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
