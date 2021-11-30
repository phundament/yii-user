<?php

class m150512_111503_user_add_deleted extends EDbMigration {

    public function up() {

        $this->execute("
                    ALTER TABLE `users`   
                      ADD COLUMN `deleted` TINYINT(1) DEFAULT 0  NULL AFTER `logintoken`;

        ");
    }

    public function down() {
        echo "m150512_111503_user_add_deleted does not support migration down.\n";
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
