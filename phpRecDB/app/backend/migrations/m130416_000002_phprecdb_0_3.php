<?php

class m130416_000002_phprecdb_0_3 extends CDbMigration {

    const DB_VERSION = 0.3;
    
    public function safeUp() {
        // from old DB Updater, not longer needed in >=1 because signature settings get an own table

        //in the previous version the signature were saved as jpg
        //and jpg quality scale was from 0-100
        //
        //now the signature file use png and png quality scale is from 0-9
        //        $signature_quality = Yii::app()->settingsManager->getPropertyValue('signature_quality');
        //        if ($signature_quality > 9) {
        //            Yii::app()->settingsManager->setPropertyValue('signature_quality', 9);
        //        }
        
        Yii::app()->settingsManager->setPropertyValue(DbMigrator::DB_VERSION,self::DB_VERSION);
    }

    public function safeDown() {
        echo "m130416_000002_phprecdb_0_3 does not support down migration.\n";
        return false;
    }

}

?>
