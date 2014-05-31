<?php

class UserdefinedForm extends SettingsDbModel {

    public $userDefined1Label = '';
    public $userDefined2Label = '';

    protected function givePropertiesDbMap() {
        return array(
            'userDefined1Label' => Record::SETTINGS_USER_DEFINED1_LABEL,
            'userDefined2Label' => Record::SETTINGS_USER_DEFINED2_LABEL,
        );
    }

    public function rules() {
        return array(
            array('userDefined1Label, userDefined2Label', 'required'),
        );
    }

}

?>
