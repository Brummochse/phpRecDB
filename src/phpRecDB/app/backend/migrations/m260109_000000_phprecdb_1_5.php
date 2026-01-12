<?php

class m260109_000000_phprecdb_1_5 extends CDbMigration {

    const DB_VERSION = 1.5;

    public function safeUp() {

        $this->addColumn('lists', 'exclude', 'TINYINT(1) NOT NULL DEFAULT 0');

        Yii::app()->settingsManager->setPropertyValue(Settings::LOCATION_FORMAT_PATTERN, '{country}, {city} - {venue} {supplement}');

        Yii::app()->settingsManager->setPropertyValue(DbMigrator::DB_VERSION, self::DB_VERSION);
    }

    public function safeDown() {
        echo 'm260109_000000_phprecdb_1_5 does not support down migration.\n';
        return false;
    }

}

?>
