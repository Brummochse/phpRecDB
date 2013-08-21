<?php

class SuggestController extends CController {

    public function accessRules() {
        return array(
            array('allow', // allow authenticated users to access all actions
                'users' => array('@'),
            ),
            array('deny'),
        );
    }

    public function actionSuggestArtist() {
        if (isset($_GET['term'])) {
            $artist = trim($_GET['term']);
            $suggest = Artist::model()->suggest($artist, 999);
            echo CJSON::encode($suggest);
        }
    }

    public function actionSuggestCountry() {
        if (isset($_GET['term'])) {
            $country = trim($_GET['term']);
            $suggest = Country::model()->suggest($country, 999);
            echo CJSON::encode($suggest);
        }
    }

    public function actionSuggestCity() {
        if (isset($_GET['term']) && isset($_GET['country'])) {

            $city = trim($_GET['term']);
            $countryFiler = trim($_GET['country']);
            $suggest = City::model()->suggest($city, $countryFiler, 999);
            echo CJSON::encode($suggest);
        }
    }

    public function actionSuggestVenue() {
        if (isset($_GET['term']) && isset($_GET['country']) && isset($_GET['city'])) {

            $venue = trim($_GET['term']);
            $countryFiler = trim($_GET['country']);
            $cityFiler = trim($_GET['city']);
            $suggest = Venue::model()->suggest($venue, $cityFiler, $countryFiler, 999);
            echo CJSON::encode($suggest);
        }
    }
}

?>
