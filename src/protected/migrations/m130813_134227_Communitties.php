<?php

class m130813_134227_Communitties extends CDbMigration
{
	public function up()
	{
    
        $this->execute("
            DROP TABLE IF EXISTS `community` ;

            CREATE  TABLE IF NOT EXISTS `community` (
            `id` INT NOT NULL AUTO_INCREMENT ,
            `name` VARCHAR(255) NOT NULL ,
            `description` TEXT NULL,
            `access` ENUM('open','request','invitation') NOT NULL ,
            PRIMARY KEY (`id`) )
            ENGINE = InnoDB;
		"); 
	}

	public function down()
	{
		echo "m130813_134227_Communitties does not support migration down.\n";
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