<?php

class ScreenshotCompressionForm extends SettingsDbModel {
    
    public $enable_compression = true;
    
    protected function givePropertiesDbMap(){
         return array(
            'enable_compression' => 'screenshot_compression',
        );
    }
    
    public function rules() {
        return array(
            array('enable_compression', 'required'),
       );
    }

    /*
     * redundant code, is needed because only in php 5.3 and above
     * it is possible to use the method form the parent class
     */
     public static function createFromSettingsDb() {
        $settingsDbModel = new ScreenshotCompressionForm();
        $settingsDbModel->loadFromSettingsDb();
        return $settingsDbModel;
    }
}

?>
