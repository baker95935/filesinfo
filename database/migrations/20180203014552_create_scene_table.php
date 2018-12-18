<?php

use think\migration\Migrator;
use think\migration\db\Column;

class CreateSceneTable extends Migrator
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
    public function change()
    {
    	$this->table('scene',['engine'=>'MyISAM'])
    	->addColumn(Column::string('name')->setComment('场景名称'))
    	->addColumn(Column::tinyInteger('type')->setComment('1是外景2是内景'))
    	->addColumn(Column::integer('create_time')->setComment('添加时间'))
    	->create();
    }
}
