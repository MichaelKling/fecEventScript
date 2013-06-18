<?php

class m130618_225631_adminUser extends CDbMigration
{
	public function up()
	{
        $this->execute("
        INSERT INTO  `administrator` (
          `username` , `password`
        )
        VALUES (
            'admin',  'd033e22ae348aeb5660fc2140aec35850c4da997'
        );
		");

	}

	public function down()
	{
		echo "m130618_225631_adminUser does not support migration down.\n";
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