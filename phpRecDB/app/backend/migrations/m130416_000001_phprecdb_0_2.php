<?php

class m130416_000001_phprecdb_0_2 extends CDbMigration{

    const DB_VERSION = 0.2;
    
    public function safeUp() {
        //add sql infrastructure for sublist handling
        $this->createTable('lists', array(
            "id" => "pk",
            "label" => "string NOT NULL",
        ));
        $this->createTable('sublists', array(
            "recordings_id" => "INTEGER NOT NULL",
            "lists_id" => "INTEGER NOT NULL",
            "UNIQUE ( recordings_id, lists_id )"
        ));
        $this->addForeignKey('fk_sublist_lists_id', 'sublists', 'lists_id', 'lists', 'id', 'CASCADE', NULL);
        $this->addForeignKey('fk_sublist_recordings_id', 'sublists', 'recordings_id', 'recordings', 'id', 'CASCADE', NULL);

        //dates can now contain hours and minutes
        $this->execute("ALTER TABLE recordings MODIFY created DATETIME");
        $this->execute("ALTER TABLE recordings MODIFY lastmodified DATETIME");

         Yii::app()->settingsManager->setPropertyValue(DbMigrator::DB_VERSION,self::DB_VERSION);
    }

    public function safeDown() {
        echo "m130416_000001_phprecdb_0_2 does not support down migration.\n";
        return false;
    }

}

?>
