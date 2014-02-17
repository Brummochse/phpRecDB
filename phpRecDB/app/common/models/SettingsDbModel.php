<?php

abstract class SettingsDbModel extends CFormModel {

    private $propertyDbMap = array();

    public function init() {
        $this->propertyDbMap = $this->givePropertiesDbMap();
        parent::init();
        $this->loadFromSettingsDb();
    }

    protected abstract function givePropertiesDbMap();

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
