<?php
include_once dirname(__FILE__) . "/../constants.php";
include_once Constants :: getFunctionsFolder() . "function.cleanUpDb.php";
include_once Constants::getClassFolder()."ScreenshotsManager.php";
include_once Constants::getClassFolder()."SignatureCreator.php";
include_once Constants :: getClassFolder() . "StateMsgHandler.php";

function deleteRecord($recordingId) {
    deleteRecords(array($recordingId));
}

function deleteRecords($recordingIds) {
     $msg="Records with ids:";

     foreach ($recordingIds as $recordingId) {

        //delete screenshots
        $screenshots = mysql_query("SELECT id from screenshot WHERE video_recordings_id=" . $recordingId) or die("MySQL-Error: " . mysql_error());
        $screenshotMngr=new ScreenshotsManager();
        while ($screenshot = mysql_fetch_row($screenshots)) {
            $screenshotId = $screenshot[0];
            $screenshotMngr->deleteScreenshot($screenshotId, "../screenshots/");
        }

        //concertid holen
        $row = mysql_fetch_array(mysql_query("SELECT * FROM recordings WHERE id=" . $recordingId));
        $concerts_id = $row['concerts_id'];

        //delete recording (audio or video with casccading)
        mysql_query("DELETE FROM `recordings` WHERE `recordings`.`id` = " . $recordingId) or die("MySQL-Error: " . mysql_error());


        $msg=$msg.$recordingId.", ";
    }
    $stateMsgHandler = StateMsgHandler :: getInstance();
    $stateMsgHandler->addStateMsg($msg."deleted");

    deleteAllUnusedDbEntrys();
    SignatureCreator::updateSignature();
}
?>
