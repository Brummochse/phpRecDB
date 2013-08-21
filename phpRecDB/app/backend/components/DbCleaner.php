<?php

class DbCleaner extends CApplicationComponent {

    public function deleteAllUnusedDbEntrys() {
        $this->deleteUnusedConcerts();
        $this->deleteUnusedVenues();
        $this->deleteUnusedCitys();
        $this->deleteUnusedCountrys();
        $this->deleteUnusedArtists();
    }

    private function deleteUnusedVenues() {
        $sqlDelete = "DELETE venues.*" .
                " FROM `venues`" .
                " LEFT JOIN concerts ON concerts.venues_id = venues.id" .
                " WHERE concerts.id IS NULL";
        Yii::app()->db->createCommand($sqlDelete)->execute();
    }

    private function deleteUnusedCitys() {
        $sqlDelete = "DELETE citys.*" .
                " FROM `citys`" .
                " LEFT JOIN concerts ON concerts.citys_id = citys.id" .
                " WHERE concerts.id IS NULL";
        Yii::app()->db->createCommand($sqlDelete)->execute();
    }

    private function deleteUnusedCountrys() {
        $sqlDelete = "DELETE countrys.*" .
                " FROM `countrys`" .
                " LEFT JOIN concerts ON concerts.countrys_id = countrys.id" .
                " WHERE concerts.id IS NULL";
        Yii::app()->db->createCommand($sqlDelete)->execute();
    }

    private function deleteUnusedArtists() {
        $sqlDelete = "DELETE artists.*" .
                " FROM `artists`" .
                " LEFT JOIN concerts ON concerts.artists_id = artists.id" .
                " WHERE concerts.id IS NULL";
        Yii::app()->db->createCommand($sqlDelete)->execute();
    }

    private function deleteUnusedConcerts() {
        $sqlDelete = "DELETE concerts . * " .
                "FROM `concerts` " .
                "LEFT JOIN recordings ON recordings.concerts_id = concerts.id " .
                "WHERE recordings.id IS NULL";
        Yii::app()->db->createCommand($sqlDelete)->execute();
    }

}

?>
