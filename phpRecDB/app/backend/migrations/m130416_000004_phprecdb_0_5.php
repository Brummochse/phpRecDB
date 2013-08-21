<?php

class m130416_000004_phprecdb_0_5 extends CDbMigration {

    const DB_VERSION = 0.5;
    
    public function safeUp() {
        //TODO: is this longer needed??
        // old updater:
         Yii::app()->settingsManager->setPropertyValue('screenshot_compression', true);
         
         Yii::app()->settingsManager->setPropertyValue(DbMigrator::DB_VERSION,self::DB_VERSION);
    }

    public function safeDown() {
        echo "m130416_000004_phprecdb_0_5 does not support down migration.\n";
        return false;
    }

}

?>
