<?php

class m141006_131501_create_table_iptb extends CDbMigration
{
    
	/**
	 * Creates initial version of the table
	 */
	public function up()
	{
        
		$this->execute("
            CREATE TABLE `iptb_ip_table` (
              `iptb_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
              `iptb_name` varchar(255) NOT NULL,
              `iptb_from` varchar(15) NOT NULL,
              `iptb_to` varchar(15) NOT NULL,
              `iptb_status` enum('active','inactive') NOT NULL,
              PRIMARY KEY (`iptb_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        ");
        
	}

	/**
	 * Drops the table
	 */
	public function down()
	{
        
		$this->dropTable('iptb_ip_table');
        
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
