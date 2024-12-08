<?php

abstract class SettingsDbModel extends CFormModel {

    public function __construct() {
        $this->loadFromSettingsDb();
    }

    public function init() {
        parent::init();
        $this->loadFromSettingsDb();
    }

    protected abstract function givePropertiesDbMap();

    public function saveToSettingsDb() {

        $class_vars = get_object_vars($this);
        $propertyDbMap = $this->givePropertiesDbMap();
        
        foreach ($class_vars as $varName => $varValue) {
            if (array_key_exists($varName, $propertyDbMap)) {
                Yii::app()->settingsManager->setPropertyValue($propertyDbMap[$varName], $varValue);
            }
        }
    }

    public function loadFromSettingsDb() {
        $class_vars = get_object_vars($this);
        $propertyDbMap = $this->givePropertiesDbMap();
        
        foreach ($class_vars as $varName => $varValue) {
            if (array_key_exists($varName, $propertyDbMap)) {
                $newVarValue = Yii::app()->settingsManager->getPropertyValue($propertyDbMap[$varName]);
                if ($newVarValue !== FALSE) {
                    $this->$varName = $newVarValue;
                }
            }
        }
    }

}

?>
