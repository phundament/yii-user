<?php

class m141006_131601_create_table_uxip extends CDbMigration
{
    
	/**
	 * Creates initial version of the table
	 */
	public function up()
	{
        
		$this->execute("
            CREATE TABLE `uxip_user_x_ip_table` (
              `uxip_user_id` int(11) NOT NULL,
              `uxip_iptb_id` smallint(5) unsigned NOT NULL,
              KEY `uxip_user_id` (`uxip_user_id`),
              KEY `uxip_iptb_id` (`uxip_iptb_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;


            ALTER TABLE `uxip_user_x_ip_table`
              ADD CONSTRAINT `uxip_user_x_ip_table_ibfk_1` FOREIGN KEY (`uxip_user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
              ADD CONSTRAINT `uxip_user_x_ip_table_ibfk_2` FOREIGN KEY (`uxip_iptb_id`) REFERENCES `iptb_ip_table` (`iptb_id`) ON DELETE CASCADE;
        ");
        
	}

	/**
	 * Drops the table
	 */
	public function down()
	{
        
		$this->dropTable('uxip_user_x_ip_table');
        
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
