<?php

class m130813_111850_RemovingAdministratorTable extends CDbMigration
{
	public function up()
	{
        $this->execute("
           DROP TABLE `administrator`;
		");
	}

	public function down()
	{
		echo "m130813_111850_RemovingAdministratorTable does not support migration down.\n";
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