<?php

class m141005_131601_alter_table_users extends CDbMigration
{
    
	/**
	 * Add column logintoken
	 */
	public function up()
	{
        
		$this->execute("
            ALTER TABLE `users` ADD `logintoken` VARCHAR(255);
        ");
        
	}

	/**
	 * Drop column logintoken
	 */
	public function down()
	{
        
		$this->execute("
            ALTER TABLE `users` DROP `logintoken`;
        ");
        
	}

	/**
	 * Creates initial version of the table in a transaction-safe way.
	 * Uses $this->up to not duplicate code.
	 */
	public function safeUp()
	{
		$this->up();
	}

	/**
	 * Drops the table in a transaction-safe way.
	 * Uses $this->down to not duplicate code.
	 */
	public function safeDown()
	{
		$this->down();
	}
}
