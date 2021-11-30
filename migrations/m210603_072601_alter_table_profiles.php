<?php

class m210603_072601_alter_table_profiles extends CDbMigration
{

	/**
	 * Creates initial version of the table
	 */
	public function up()
	{

		$this->execute("
            ALTER TABLE `profiles`   
              CHANGE `type` `type` TINYINT(4) DEFAULT 0  NOT NULL;
          ");
        
	}

	/**
	 * Drops the table
	 */
	public function down()
	{

        
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
