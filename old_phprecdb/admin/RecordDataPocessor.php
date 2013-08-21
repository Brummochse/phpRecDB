<?php
include_once Constants :: getClassFolder() . "SignatureCreator.php";
include_once Constants :: getClassFolder() . "RecordManager.php";
include_once Constants :: getFunctionsFolder() . "function.cleanUpDb.php";

abstract class RecordDataPocessor extends ContentPageSmarty {

    function processRecordData($concertId,$c_recordingId,$c_morerecords,$c_videoOrAudio,$linky,$smarty) {
        $newRecord = empty ($c_recordingId);
        $editRecord = !$newRecord;
        $editAllRecords = $c_morerecords == 'all';
        $editOnlyThisRecord = !$editAllRecords;

        if ($editRecord) {
            //change concertid in record
            if ($editOnlyThisRecord) {
                RecordManager:: changeConcertIdInRecord($c_recordingId, $concertId);
            }
            if ($editAllRecords) {
                $recordsSql = "SELECT id FROM `recordings` WHERE concerts_id=$c_concertId";
                $records = mysql_query($recordsSql) or die("MySQL-Error: " . mysql_error());
                while ($record = mysql_fetch_row($records)) {
                    $oldRecordId = $record[0];
                    RecordManager::  changeConcertIdInRecord($oldRecordId, $concertId);
                }
            }
        }
        if ($newRecord) {
            //adding a new record for the show
            $recordingId = RecordManager::createRecordAndGetId($concertId);
            if ($c_videoOrAudio == 'video') {
                $videoId = RecordManager::createVideoAndGetId($recordingId);
            } else
            if ($c_videoOrAudio == 'audio') {
                $audioId =RecordManager:: createAudioAndGetId($recordingId);
            } else
                throw new Exception('no video/audio-selection');

            $editRecordLink = "index.php" . $linky->encryptName('edit Record', array (
                    'id' => $recordingId
            ));

            $smarty->assign('audioId', $audioId);
            $smarty->assign('videoId', $videoId);
            $smarty->assign('recordingId', $recordingId);

            $smarty->assign('c_videoOrAudio', $c_videoOrAudio);
            $smarty->assign('editRecordLink', $editRecordLink);
        }

        deleteAllUnusedDbEntrys();
        SignatureCreator::updateSignature();
    }
}
?>
