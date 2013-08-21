<?php

class SettingsManager extends CApplicationComponent {

    private $settingsTableName = "settings";

    public function init() {
        $this->ensureSettingsTableExistence();
        parent::init();
    }

    public function setPropertyValue($property, $value) {
        $sqlQuery = "REPLACE INTO " . $this->settingsTableName . " (property, value)" .
                " VALUES ('$property', '$value');";
        Yii::app()->db->createCommand($sqlQuery)->execute();
    }

    public function containsProperty($property) {
        $result = $this->getPropertyValue($property);
        return $result !== false;
    }

    public function getPropertyValue($property) {
        $sqlQuery = "SELECT value FROM " . $this->settingsTableName . "" .
                " WHERE property='$property'";
        return Yii::app()->db->createCommand($sqlQuery)->queryScalar();
    }

    private function ensureSettingsTableExistence() {
        
        $dbTables=Yii::app()->db->schema->tableNames;
        
        if (! in_array($this->settingsTableName,$dbTables) ) {
            $sqlQuery = "CREATE TABLE " . $this->settingsTableName . " (" .
                    "property varchar(255) NOT NULL ," .
                    "value varchar(255) ," .
                    "UNIQUE (property)" .
                    ");";
            Yii::app()->db->createCommand($sqlQuery)->execute();
        };
    }

}

?>
