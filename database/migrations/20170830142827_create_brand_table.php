<?php

use think\migration\Migrator;
use think\migration\db\Column;

class CreateBrandTable extends Migrator
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
	  $this->table('brand',['engine'=>'MyISAM'])
	    ->addColumn(Column::string('name')->setUnique()->setComment('名称'))
	    ->addColumn(Column::string('location')->setComment('位置'))
	    ->addColumn(Column::string('title')->setComment('标题'))
	    ->addColumn(Column::text('content')->setComment('内容'))
	    
	    ->addColumn(Column::string('video1')->setComment('视频1'))
	    ->addColumn(Column::string('video1pic')->setComment('视频1封面'))
	    
	    ->addColumn(Column::string('video2')->setComment('视频2'))
	    ->addColumn(Column::string('video2pic')->setComment('视频2封面'))
	    ->addColumn(Column::string('video3')->setComment('视频3'))
	    ->addColumn(Column::string('video3pic')->setComment('视频3封面'))
	    
	    ->addColumn(Column::integer('status')->setComment('状态'))
	    ->addColumn(Column::integer('create_time')->setComment('添加时间'))
	    ->create();
	}
	
	/**
	* Down Method.
	*/
	public function down()
	{
	    $this->dropTable('brand');
	}
}
