<?php

class m130416_000003_phprecdb_0_4 extends CDbMigration {

    const DB_VERSION = 0.4;
    
    public function safeUp() {
        // add visibility coloumn to recordings table
        $this->addColumn('recordings', 'visible', 'boolean DEFAULT 1');

        // add foreing key to screenshot for recording_id
        $this->addForeignKey('recordingFK1', 'screenshot', 'video_recordings_id', 'recordings', 'id', NULL, NULL);

        //create table for youtube samples
        $this->createTable('youtubesamples', array(
            "id" => "pk",
            "title" => "string",
            "youtubeId" => "string NOT NULL",
            "recordings_id" => "INTEGER NOT NULL",
            "order_id" => "INT(10) unsigned not null",
        ));
        $this->addForeignKey('fk_youtubesamples_recordings_id', 'youtubesamples', 'recordings_id', 'recordings', 'id', 'CASCADE', NULL);
        
         Yii::app()->settingsManager->setPropertyValue(DbMigrator::DB_VERSION,self::DB_VERSION);
    }

    public function safeDown() {
        echo "m130416_000003_phprecdb_0_4 does not support down migration.\n";
        return false;
    }

}

?>
