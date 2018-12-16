<?php

class UserdefinedForm extends SettingsDbModel {

    public $userDefined1Label = '';
    public $userDefined2Label = '';

    protected function givePropertiesDbMap() {
        return array(
            'userDefined1Label' => Settings::USER_DEFINED1_LABEL,
            'userDefined2Label' => Settings::USER_DEFINED2_LABEL,
        );
    }

    public function rules() {
        return array(
            array('userDefined1Label, userDefined2Label', 'required'),
            array('userDefined1Label, userDefined2Label', 'length','max' => 255),
        );
    }
}
?>
