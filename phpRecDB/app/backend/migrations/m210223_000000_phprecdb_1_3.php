<?php

class m210223_000000_phprecdb_1_3 extends CDbMigration {

    const DB_VERSION = 1.3;

    public function safeUp() {
        $this->addColumn('recordings', 'size', 'BIGINT');
        $this->addColumn('video', 'width', 'INT(10)');
        $this->addColumn('video', 'height', 'INT(10)');
        $this->addColumn('video', 'menu', 'tinyint(1) ');
        $this->addColumn('video', 'chapters', 'tinyint(1) ');

        Yii::app()->settingsManager->setPropertyValue(DbMigrator::DB_VERSION, self::DB_VERSION);
    }

    public function safeDown() {
        echo 'm210223_000000_phprecdb_1_3 does not support down migration.\n';
        return false;
    }

}

?>
