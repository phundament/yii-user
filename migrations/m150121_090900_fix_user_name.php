<?php

class m150121_090900_fix_user_name extends EDbMigration
{
	public function up()
	{
                $this->execute("
                    ALTER TABLE `users`     
                    CHANGE `username` `username` VARCHAR(128) CHARSET utf8 COLLATE utf8_general_ci DEFAULT ''  NOT NULL;

        ");
	}

	public function down()
	{
		echo "m150121_090900_fix_user_name does not support migration down.\n";
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