<?php

class AddRecordForm extends ConcertForm {

    public $va = VA::VIDEO;

    public function rules() {
        return array_merge_recursive(parent::rules(), array(
            array('va', 'required'),
        ));
    }

    public function attributeLabels() {
        return array(
            'va' => 'Type',
        );
    }

}

?>
