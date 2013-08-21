<?php
include_once Constants::getClassFolder()."ShowManager.php";
include_once Constants::getAdminFolder()."RecordDataPocessor.php";

class ContentPage extends RecordDataPocessor {

    public function getPageTemplateFileName() {
        return "recordAdded.tpl";
    }

    public function execute($smarty,$linky) {
        session_start();

        $selectedShow = $_POST['select'];

        $id_artist = $_SESSION['id_artist'];
        $id_country = $_SESSION['id_country'];
        $id_city = $_SESSION['id_city'];
        $id_venue = $_SESSION['id_venue'];
        $miscBoolean = $_SESSION['miscBoolean'];
        $c_date = $_SESSION['c_date'];
        $c_supplement = $_SESSION['c_supplement'];
        $c_videoOrAudio = $_SESSION['c_videoOrAudio'];

        $c_concertId = $_SESSION['c_concertId'];
        $c_recordingId = $_SESSION['c_recordingId'];
        $c_morerecords = $_SESSION['c_morerecords'];

        if (empty ($selectedShow))
            throw new Exception('no artist');

        if ($selectedShow == 'new') {
            $concertId = ShowManager:: insertConcertAndGetId($id_artist, $c_date, $id_country, $id_city, $id_venue, $c_supplement, $miscBoolean, $c_videoOrAudio);
            $smarty->assign('concertId', $concertId);
        } else {
            $concertId = $selectedShow;
        }

        $this->processRecordData($concertId,$c_recordingId,$c_morerecords,$c_videoOrAudio,$linky,$smarty);
    }
}
?>
