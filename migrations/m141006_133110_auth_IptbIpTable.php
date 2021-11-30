<?php
 
class m141006_133110_auth_IptbIpTable extends CDbMigration
{

    public function up()
    {
        $this->execute("
            INSERT INTO `AuthItem` (`name`, `type`, `description`, `bizrule`, `data`) VALUES('User.IptbIpTable.*','0','User.IptbIpTable',NULL,'N;');
            INSERT INTO `AuthItem` (`name`, `type`, `description`, `bizrule`, `data`) VALUES('User.IptbIpTable.Create','0','User.IptbIpTable module create',NULL,'N;');
            INSERT INTO `AuthItem` (`name`, `type`, `description`, `bizrule`, `data`) VALUES('User.IptbIpTable.View','0','User.IptbIpTable module view',NULL,'N;');
            INSERT INTO `AuthItem` (`name`, `type`, `description`, `bizrule`, `data`) VALUES('User.IptbIpTable.Update','0','User.IptbIpTable module update',NULL,'N;');
            INSERT INTO `AuthItem` (`name`, `type`, `description`, `bizrule`, `data`) VALUES('User.IptbIpTable.Delete','0','User.IptbIpTable module delete',NULL,'N;');
                
            INSERT INTO `AuthItem` VALUES('User.IptbIpTableCreate', 2, 'User.IptbIpTable create', NULL, 'N;');
            INSERT INTO `AuthItem` VALUES('User.IptbIpTableUpdate', 2, 'User.IptbIpTable update', NULL, 'N;');
            INSERT INTO `AuthItem` VALUES('User.IptbIpTableDelete', 2, 'User.IptbIpTable delete', NULL, 'N;');
            INSERT INTO `AuthItem` VALUES('User.IptbIpTableView', 2, 'User.IptbIpTable view', NULL, 'N;');
            
            INSERT INTO `AuthItemChild` VALUES('User.IptbIpTableCreate', 'User.IptbIpTable.Create');
            INSERT INTO `AuthItemChild` VALUES('User.IptbIpTableUpdate', 'User.IptbIpTable.Update');
            INSERT INTO `AuthItemChild` VALUES('User.IptbIpTableDelete', 'User.IptbIpTable.Delete');
            INSERT INTO `AuthItemChild` VALUES('User.IptbIpTableView', 'User.IptbIpTable.View');

        ");
    }

    public function down()
    {
        $this->execute("
            DELETE FROM `AuthItemChild` WHERE `parent` = 'User.IptbIpTableEdit';
            DELETE FROM `AuthItemChild` WHERE `parent` = 'User.IptbIpTableView';

            DELETE FROM `AuthItem` WHERE `name` = 'User.IptbIpTable.*';
            DELETE FROM `AuthItem` WHERE `name` = 'User.IptbIpTable.edit';
            DELETE FROM `AuthItem` WHERE `name` = 'User.IptbIpTable.fullcontrol';
            DELETE FROM `AuthItem` WHERE `name` = 'User.IptbIpTable.readonly';
            DELETE FROM `AuthItem` WHERE `name` = 'User.IptbIpTableEdit';
            DELETE FROM `AuthItem` WHERE `name` = 'User.IptbIpTableView';
        ");
    }

    public function safeUp()
    {
        $this->up();
    }

    public function safeDown()
    {
        $this->down();
    }
}


