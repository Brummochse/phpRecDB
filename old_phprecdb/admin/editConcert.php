<?php

include_once "../settings/dbConnection.php";
include_once  Constants::getFunctionsFolder()."function.getConcertInfo.php";
include_once  Constants::getAdminFolder()."EditMenu.php";

class ContentPage extends ContentPageSmarty {

    public function getPageTemplateFileName() {
        return "editConcert.tpl";
    }

    public function execute($smarty,$linky) {
        dbConnect();

        if (isset ($_GET['id'])) {
            $recordingId = (int) $_GET['id'];

            $sqlSelect = "SELECT concerts.id " .
                    "FROM concerts " .
                    "LEFT OUTER JOIN recordings ON concerts.id = recordings.concerts_id " .
                    "WHERE recordings.id=" . $recordingId;
            $result = mysql_query($sqlSelect) or die("MySQL-Error: " . mysql_error());
            $concert = mysql_fetch_row($result);

            $concertId = $concert[0];

            include_once "../constants.php";
            include_once ('../libs/Smarty/Smarty.class.php');
            include_once (Constants::getClassFolder()."Linky.php");

            ///////////counting records which belong to this show
            $sqlSelect = "SELECT id FROM `recordings` WHERE concerts_id=" . $concertId;
            mysql_query($sqlSelect) or die("MySQL-Error: " . mysql_error());
            $recordsCount = mysql_affected_rows();

            if ($recordsCount > 1) {
                $smarty->assign('recordsPerShowCount', $recordsCount);
            }
            ///////////

            EditMenu::addEditMenuLinksToSmarty($smarty, $linky, $recordingId);

            $smarty->assign('recordingId', $recordingId);

            getConcertInfo($recordingId, false, $smarty);

            $smarty->assign('concertId', $concertId);
            $smarty->assign('audioOrVideoSelection', 'false');

            $smarty->assign("relativeTemplatesPath", getRelativePathTo(Constants::getTemplateFolder()));
            $smarty->assign('addConcertLink', $linky->encryptName('Add Concert'));
        }
    }

}
?>
