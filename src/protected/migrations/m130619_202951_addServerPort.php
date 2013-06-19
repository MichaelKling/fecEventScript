<?php

class m130619_202951_addServerPort extends CDbMigration
{
	public function up()
	{
        $this->execute("
			ALTER TABLE `server` ADD `port` INTEGER NULL AFTER `ip`;
		");
        $this->execute("
			ALTER TABLE `server` ADD `type`  ENUM('flashpoint','armedassault','arma2','arma3') NULL  AFTER `port`;
		");
	}

	public function down()
	{
		echo "m130619_202951_addServerPort does not support migration down.\n";
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