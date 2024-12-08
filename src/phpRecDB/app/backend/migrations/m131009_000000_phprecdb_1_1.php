<?php

class m131009_000000_phprecdb_1_1 extends CDbMigration {

    const DB_VERSION = 1.1;

    public function safeUp() {

        //new fields for record
        $this->addColumn('recordings', 'hiddennotes', 'text');
        $this->addColumn('recordings', 'userdefined1', 'string');
        $this->addColumn('recordings', 'userdefined2', 'string');

        // set default settings for user defined cols
        Yii::app()->settingsManager->setPropertyValue(Settings::USER_DEFINED1_LABEL, "User Defined 1");
        Yii::app()->settingsManager->setPropertyValue(Settings::USER_DEFINED2_LABEL, "User Defined 2");

        
        //add database infrastructure to save fontsize for signatures
        $this->addColumn('signature', 'fontSize', 'integer');
        $signatures = Signature::model()->findAll();
        foreach ($signatures as $signature) {
            $signature->fontSize = 9;
            $signature->save();
        }

        // set default settings for configurable list cols
        Yii::app()->settingsManager->setPropertyValue(Settings::LIST_COLS_FRONTEND, ColumnStock::SETTINGS_DEFAULT_FRONTEND);
        Yii::app()->settingsManager->setPropertyValue(Settings::LIST_COLS_BACKEND, ColumnStock::SETTINGS_DEFAULT_BACKEND);

        //create new table for saving ip adresses for record detail visits
        $this->createTable('uservisit', array(
            'id' => 'pk',
            'record_id' => 'int', //has no foreign key, becasue it is null when page is set
            'page' => 'string',
            'ip' => 'string NOT NULL',
            'useragent' => 'string',
            'date' => 'datetime NOT NULL',
                ), 'ENGINE=InnoDB CHARSET=utf8');

        // create new table for saving record visits
        $this->createTable('recordvisit', array(
            "id" => "pk",
            "record_id" => "INTEGER NOT NULL",
            "visitors" => "INTEGER DEFAULT 0",
                ), 'ENGINE=InnoDB CHARSET=utf8');
        $this->addForeignKey('fk_recordvisit_recordings_id', 'recordvisit', 'record_id', 'recordings', 'id', 'CASCADE', NULL);


        Yii::app()->settingsManager->setPropertyValue(DbMigrator::DB_VERSION, self::DB_VERSION);
    }

    public function safeDown() {
        echo 'm131009_000000_phprecdb_1_1 does not support down migration.\n';
        return false;
    }

}

?>
