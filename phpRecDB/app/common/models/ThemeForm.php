<?php

class ThemeForm extends SettingsDbModel {

    public $theme = ' default';

    protected function givePropertiesDbMap() {
        return array(
            'theme' => 'theme_name',
        );
    }

    public function rules() {
        return array(
            array('theme', 'required'),
        );
    }

}

?>
