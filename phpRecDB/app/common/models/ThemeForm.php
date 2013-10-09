<?php

class ThemeForm extends SettingsDbModel {

    public $theme = ' default';

    /*
     * redundant code, is needed because only in php 5.3 and above
     * it is possible to use the method form the parent class
     */

    public static function createFromSettingsDb() {
        $settingsDbModel = new ThemeForm();
        $settingsDbModel->loadFromSettingsDb();
        return $settingsDbModel;
    }

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
