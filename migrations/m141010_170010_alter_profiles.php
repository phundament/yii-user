<?php
 
class m141010_170010_alter_profiles extends CDbMigration
{

    public function up()
    {
        $this->execute("
            ALTER TABLE `profiles` ADD `lang` CHAR( 2 ) NULL;
            INSERT INTO `profiles_fields` (`varname`, `title`, `field_type`, `field_size`, `field_size_min`, `required`, `match`, `range`, `error_message`, `other_validator`, `default`, `widget`, `widgetparams`, `position`, `visible`) VALUES('lang', 'The default language', 'VARCHAR', 2, 2, 0, '', '', '', NULL, '', '', NULL, 10, 3);
        ");
    }
    
    public function down()
    {
        $this->execute("
            ALTER TABLE `profiles` DROP `lang`;
            DELETE FROM `profiles_fields` WHERE `profiles_fields`.`varname` = 'lang';
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


