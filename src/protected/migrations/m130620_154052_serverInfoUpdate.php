<?php

class m130620_154052_serverInfoUpdate extends CDbMigration
{
	public function up()
	{
        $this->execute("
			ALTER TABLE `server` ADD `country` VARCHAR(3) NULL AFTER `type`;
		");

        $this->execute("
			ALTER TABLE `serverInfo` ADD `timeframe` INT NULL AFTER `date`;
		");
	}

	public function down()
	{
		echo "m130620_154052_serverInfoUpdate does not support migration down.\n";
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