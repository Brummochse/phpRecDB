<?php

class MyModel extends CModel {

    public $picture;
    public $file_name;

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        return array(
            // ... more rules here
            array('picture', 'length', 'max' => 255, 'tooLong' => '{attribute} is too long (max {max} chars).', 'on' => 'upload'),
            array('picture', 'file', 'types' => 'jpg,jpeg,gif,png', 'maxSize' => 1024 * 1024 * 2, 'tooLarge' => 'Size should be less then 2MB !!!', 'on' => 'upload'),
                // ... more rules here
        );
    }

    public function attributeNames() {
        return array('picture','file_name');
    }

}