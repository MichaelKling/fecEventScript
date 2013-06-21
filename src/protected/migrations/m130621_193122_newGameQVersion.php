<?php

class m130621_193122_newGameQVersion extends CDbMigration
{
	public function up()
	{
        $this->execute("
            ALTER TABLE  `server` CHANGE  `type`
              `type` ENUM(  'flashpoint',  'armedassault',  'arma2',  'arma3',  'gamespy', 'armedassault2',  'armedassault2oa',  'armedassault3' )
              CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL;
		");

        $this->execute("
            UPDATE `server` SET  `type` = 'gamespy' WHERE  `type` = 'flashpoint';
		");
        $this->execute("
            UPDATE `server` SET  `type` = 'armedassault2' WHERE  `type` = 'arma2';
		");
        $this->execute("
            UPDATE `server` SET  `type` = 'armedassault3' WHERE  `type` = 'arma3';
		");

        $this->execute("
            ALTER TABLE  `server` CHANGE  `type`
              `type` ENUM( 'gamespy', 'armedassault', 'armedassault2',  'armedassault2oa',  'armedassault3' )
              CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL;
		");
	}

	public function down()
	{
		echo "m130621_193122_newGameQVersion does not support migration down.\n";
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