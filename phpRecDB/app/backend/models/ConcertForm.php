<?php

class ConcertForm extends CFormModel {

    public $artist;
    public $date;
    public $country;
    public $city;
    public $venue;
    public $supplement;
    public $misc = false;

    public function rules() {
        return array(
            array('artist,date,misc', 'required'),
            array('misc', 'boolean'),
            array('artist,country,city,venue,supplement', 'length', 'max' => 255),
        );
    }

  

}

?>
