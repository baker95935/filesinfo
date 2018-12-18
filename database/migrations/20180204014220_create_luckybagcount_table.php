<?php

use think\migration\Migrator;
use think\migration\db\Column;

class CreateLuckybagcountTable extends Migrator
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
		$this->table('luckybagcount',['engine'=>'MyISAM'])
    	->addColumn(Column::integer('create_time')->setComment('Ìí¼ÓÊ±¼ä'))
    	->addColumn(Column::string('ipaddr')->setComment('IPµØÖ·'))
    	->addColumn(Column::integer('scene_id')->setDefault(0)->setComment('¸£´ü³¡¾°ID'))
    	->addColumn(Column::integer('luckybag_click')->setDefault(0)->setComment('¸£´üµã»÷'))
    	->addColumn(Column::integer('adviser_click')->setDefault(0)->setComment('¹ËÎÊµã»÷'))
    	->addColumn(Column::integer('testdrive_click')->setDefault(0)->setComment('ÊÔ¼İµã»÷'))
    	->addColumn(Column::integer('buy_click')->setDefault(0)->setComment('¶©¹ºµã»÷'))
    	->addColumn(Column::integer('activity_click')->setDefault(0)->setComment('»î¶¯µã»÷'))
    	->addColumn(Column::integer('finance_click')->setDefault(0)->setComment('½ğÈÚµã»÷'))
    	->addColumn(Column::integer('substitution_click')->setDefault(0)->setComment('ÖÃ»»µã»÷'))
    	->create();
    }
}
