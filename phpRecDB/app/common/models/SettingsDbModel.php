<?php

abstract class SettingsDbModel extends CFormModel {

    private $propertyDbMap = array();

    public function init() {
        $this->propertyDbMap = $this->givePropertiesDbMap();
        parent::init();
    }

    protected abstract function givePropertiesDbMap();

    /**
     *  new static is only available in php 5.3
     * 
     * to support older versions this code is copied redundant to all child classes
     */
//    public static function createFromSettingsDb() {
//        $settingsDbModel = new static;
//        $settingsDbModel->loadFromSettingsDb();
//        return $settingsDbModel;
//    }

    public function saveToSettingsDb() {

        $class_vars = get_object_vars($this);

        foreach ($class_vars as $varName => $varValue) {
            if (array_key_exists($varName, $this->propertyDbMap)) {
                Yii::app()->settingsManager->setPropertyValue($this->propertyDbMap[$varName], $varValue);
            }
        }
    }

    public function loadFromSettingsDb() {
        $class_vars = get_object_vars($this);

        foreach ($class_vars as $varName => $varValue) {
            if (array_key_exists($varName, $this->propertyDbMap)) {
                $newVarValue = Yii::app()->settingsManager->getPropertyValue($this->propertyDbMap[$varName]);
                if ($newVarValue !== FALSE) {
                    $this->$varName = $newVarValue;
                }
            }
        }
    }

}

?>
