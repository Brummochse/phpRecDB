<?php

class m131009_000000_phprecdb_1_1 extends CDbMigration {

    const DB_VERSION = 1.1;

    public function safeUp() {

        //add database infrastructure to save fontsize fro signatures
        $this->addColumn('signature', 'fontSize', 'integer');
        $signatures = Signature::model()->findAll();
        foreach ($signatures as $signature) {
            $signature->fontSize = 9;
            $signature->save();
        }

        // set default settings for configurable list cols
        Yii::app()->settingsManager->setPropertyValue(ColumnStock::SETTINGS_DB_NAME, ColumnStock::SETTINGS_DEFAULT);

        Yii::app()->settingsManager->setPropertyValue(DbMigrator::DB_VERSION, self::DB_VERSION);
    }

    public function safeDown() {
        echo "m131009_000000_phprecdb_1_1 does not support down migration.\n";
        return false;
    }

}

?>
