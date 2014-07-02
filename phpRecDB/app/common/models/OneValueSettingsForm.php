<?php

class OneValueSettingsForm extends SettingsDbModel {

    public $value;
    private $valueDbName;
    private $valueLabel ;

    public function __construct($valueDbName, $defaultValue,$valueLabel) {
        $this->valueDbName = $valueDbName;
        $this->value = $defaultValue;
        $this->valueLabel = $valueLabel;
        parent::__construct();
    }

    protected function givePropertiesDbMap() {
        return array(
            'value' => $this->valueDbName,
        );
    }

    public function rules() {
        return array(
            array('value', 'required'),
        );
    }

    public function attributeLabels() {
        return array(
            'value' => $this->valueLabel,
        );
    }

}

?>
