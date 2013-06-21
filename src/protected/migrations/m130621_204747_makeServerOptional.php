<?php

class m130621_204747_makeServerOptional extends CDbMigration
{
	public function up()
	{
        $this->execute("
            ALTER TABLE  `event` CHANGE  `server_id`  `server_id` INT( 11 ) NULL;
		");
	}

	public function down()
	{
		echo "m130621_204747_makeServerOptional does not support migration down.\n";
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