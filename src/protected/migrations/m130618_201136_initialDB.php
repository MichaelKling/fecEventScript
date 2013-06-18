<?php

class m130618_201136_initialDB extends CDbMigration
{
	public function up()
	{
        $path = Yii::app()->getBasePath();
        $path.= "/../../database/fecEventScript.sql";
        $content = file_get_contents($path);
        $this->execute($content);
	}

	public function down()
	{
		echo "m130618_201136_initialDB does not support migration down.\n";
		return false;
	}

	/*
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
	}

	public function safeDown()
	{
	}
	*/
}