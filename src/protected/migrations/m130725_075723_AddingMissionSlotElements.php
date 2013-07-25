<?php

class m130725_075723_AddingMissionSlotElements extends CDbMigration
{
	public function up()
	{
        $this->execute("
           ALTER TABLE  `missionslotgroup` ADD  `weight` INT NOT NULL ,
           ADD  `group` ENUM(  'BLUFOR',  'OPFOR',  'Independend',  'Civil' ) NOT NULL;
		");
        $this->execute("
           ALTER TABLE  `missionslot` ADD  `weight` INT NOT NULL;
		");
        $this->execute("
           ALTER TABLE  `slotgroup` ADD  `weight` INT NOT NULL ,
           ADD  `group` ENUM(  'BLUFOR',  'OPFOR',  'Independend',  'Civil' ) NOT NULL;
		");
        $this->execute("
           ALTER TABLE  `slot` ADD  `weight` INT NOT NULL;
		");
        $this->execute("
           ALTER TABLE  `missionslot` CHANGE  `id`  `id` INT( 11 ) NOT NULL AUTO_INCREMENT;
		");
        $this->execute("
           ALTER TABLE  `missionslotgroup` CHANGE  `id`  `id` INT( 11 ) NOT NULL AUTO_INCREMENT;
		");
	}

	public function down()
	{
		echo "m130725_075723_AddingMissionSlotElements does not support migration down.\n";
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