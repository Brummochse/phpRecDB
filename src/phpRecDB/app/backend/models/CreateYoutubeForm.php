<?php

class CreateYoutubeForm extends CFormModel {

    public $title;
    public $youtubeUrl;

    /**
     * Declares the validation rules.
     * The rules state that username and password are required,
     * and password needs to be authenticated.
     */
    public function rules() {
        return array(
            array('youtubeUrl', 'youtubeUrlValidator'),
            array('title', 'length', 'max' => 255),
        );
    }

    public function youtubeUrlValidator($attribute, $params) {
        if (Youtube::model()->extractYoutubeId($this->$attribute) == NULL) {
            $this->addError($attribute, 'url does not contain a valid Youtube ID!');
        }
    }

}
