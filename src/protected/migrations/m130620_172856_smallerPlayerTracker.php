<?php

class m130620_172856_smallerPlayerTracker extends CDbMigration
{
	public function up()
	{
        $this->execute("
			ALTER TABLE `member` ADD `playername` VARCHAR(255) NOT NULL AFTER `name`;
		");

        $this->execute("
			ALTER TABLE `playeractiveitem` DROP `name`;
		");
	}

	public function down()
	{
		echo "m130620_172856_smallerPlayerTracker does not support migration down.\n";
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