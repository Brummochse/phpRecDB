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
}

?>
