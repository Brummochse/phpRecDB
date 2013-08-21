<?php
include_once  Constants::getFunctionsFolder()."function.evaluateBoolean.php";
include_once Constants::getClassFolder()."ShowManager.php";
include_once Constants::getAdminFolder()."RecordDataPocessor.php";

class ContentPage extends RecordDataPocessor {

    private $pageTemplateFile;

    public function getPageTemplateFileName() {
        return $this->pageTemplateFile;
    }

    public function execute($smarty, $linky) {

        //todo
        //session id benutzen
        session_start();

        foreach ($_POST AS $key => $value) {
            $_POST[$key] = mysql_real_escape_string(trim($value));
        }

        //when editing this 2 varialbes are set
        $c_concertId = $_POST['concertid'];
        $c_recordingId = $_POST['recordingId'];
        $c_morerecords = $_POST['morerecords']; //{'all','this'}

        $c_artist = $_POST['artist'];
        $c_date = $_POST['date'];
        $c_country =$_POST['country'];
        $c_city = $_POST['city'];
        $c_venue =$_POST['venue'];
        $c_supplement = $_POST['supplement'];
        $c_misc = $_POST['misc'];
        $c_videoOrAudio = $_POST['videooraudio'];

        if (empty ($c_artist))
            throw new Exception('no artist');
        if (empty ($c_date))
            throw new Exception('no date');

        //todo
        //- chekc ob date valid
        //- city,country,venue und supplement d�rfen nciht alle glecihzeitig leer sein

        $id_artist = ShowManager::getArtistId($c_artist);
        $id_country = ShowManager::getCountryId($c_country);
        $id_city = ShowManager::getCityId($c_city, $id_country);
        $id_venue = ShowManager::getVenueId($c_venue, $id_city);
        $miscBoolean = evaluateBoolean($c_misc);

        $_SESSION['id_artist'] = $id_artist;
        $_SESSION['id_country'] = $id_country;
        $_SESSION['id_city'] = $id_city;
        $_SESSION['id_venue'] = $id_venue;
        $_SESSION['miscBoolean'] = $miscBoolean;
        $_SESSION['c_date'] = $c_date;
        $_SESSION['c_supplement'] = $c_supplement;
        $_SESSION['c_videoOrAudio'] = $c_videoOrAudio;
        $_SESSION['c_supplement'] = $c_supplement;

        $_SESSION['c_concertId'] = $c_concertId;
        $_SESSION['c_recordingId'] = $c_recordingId;
        $_SESSION['c_morerecords'] = $c_morerecords;

        if (!$this->concertAlreadyExist($id_artist, $c_date, $miscBoolean, $c_artist, $c_concertId)) {
            $concertId =ShowManager:: insertConcertAndGetId($id_artist, $c_date, $id_country, $id_city, $id_venue, $c_supplement, $miscBoolean);

            $smarty->assign('concertId', $concertId);
            $this->pageTemplateFile="recordAdded.tpl";

            $this->processRecordData($concertId,$c_recordingId,$c_morerecords,$c_videoOrAudio,$linky,$smarty);
        }

    }
   

    function concertAlreadyExist($id_artist, $c_date, $miscBoolean, $c_artist, $c_concertId) {
        $sqlSelect = "SELECT concerts.id,concerts.date, countrys.name, citys.name, venues.name, concerts.supplement " .
                "FROM concerts " .
                "LEFT OUTER JOIN countrys ON countrys.id = concerts.countrys_id " .
                "LEFT OUTER JOIN citys ON citys.id = concerts.citys_id " .
                "LEFT OUTER JOIN venues ON venues.id = concerts.venues_id " .
                "WHERE artists_id=" . $id_artist . " AND date='" . $c_date . "' AND misc =" . $miscBoolean;
        if (!empty ($c_concertId)) {
            $sqlSelect = $sqlSelect . " AND concerts.id<>$c_concertId";
        }

        $concerts = mysql_query($sqlSelect) or die("MySQL-Error: " . mysql_error());
        if (mysql_num_rows($concerts) > 0) {

            global $smarty;
            global $linky;

            $smarty->assign('c_artist', $c_artist);
            $smarty->assign('c_date', $c_date);
            $smarty->assign('miscBoolean', $miscBoolean);
            $this->pageTemplateFile="selectConcert.tpl";

            $existingConcerts = array ();
            while ($concert = mysql_fetch_row($concerts)) {
                $existingConcert = array (
                        'id' => $concert[0],
                        'date' => $concert[1],
                        'country' => $concert[2],
                        'city' => $concert[3],
                        'venue' => $concert[4],
                        'supplement' => $concert[5]
                );
                $existingConcerts[] = $existingConcert;
            }
            $smarty->assign('appendRecordingLink', $linky->encryptName('Append Recording'));
            $smarty->assign('concerts', $existingConcerts);

            return true;
        } else {
            return false;
        }
    }


}
?>
