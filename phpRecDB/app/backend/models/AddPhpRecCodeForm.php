<?php

class AddPhpRecCodeForm extends CFormModel {

    public $file;
    public $text;
    public $visible;

    public function rules() {
        return array(

        );
    }
    
 public function attributeLabels() {
        return array(
            'text' => 'paste phpRecCode',
            'file' => 'or upload container',
            
        );
    }
  

}

?>
