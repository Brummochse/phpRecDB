<?php

class AddRecordForm extends ConcertForm {

    public $va = VA::VIDEO;
    public $visible = 1;

    public function rules() {
        return array_merge_recursive(parent::rules(), array(
            array('va', 'required'),
            array('visible', 'required'),
        ));
    }

    public function attributeLabels() {
        return array(
            'va' => 'Type',
            'visible' => 'Visible',
            
        );
    }

}

?>
