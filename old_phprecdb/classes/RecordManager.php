<?php

class RecordManager {
    static function updateAudio($frequence,  $bitrate,  $recordingId) {
        $sql = "UPDATE `audio` SET  ".
        " `bitrate` =  ".$bitrate.
        " ,  `frequence` = ".$frequence.
        " WHERE `recordings_id` = '".$recordingId."' ";
        mysql_query($sql) or die(mysql_error());
    }

    static function updateVideo($aspectratio_id,  $videoformat_id,  $bitrate,  $authorer,  $recordingId) {
        $sql = "UPDATE `video` SET  ".
                " `aspectratio_id` = ".$aspectratio_id.
                " ,  `videoformat_id` = ".$videoformat_id.
                " ,  `bitrate` =  ".$bitrate.
                " ,  `authorer` =  '".$authorer."'".
                " WHERE `recordings_id` = '".$recordingId."' ";
        mysql_query($sql) or die(mysql_error());
    }

    static function updateRecord($tradestatus_id,  $rectypes_id,  $sources_id,  $media_id,  $quality,  $setlist,  $notes,  $sourcenotes,  $taper,  $transferer,  $sourceidentification,  $sumlength,  $summedia,  $recordingId, $isVisible=1) {
        $sql = "UPDATE `recordings` SET  ".
                "`tradestatus_id` =  ".$tradestatus_id.
                " , `rectypes_id` = ". $rectypes_id.
                " , `sources_id` = ".$sources_id.
                " ,  `media_id` = ".$media_id.
                " ,  `quality` = ".$quality.
                " ,  `setlist` =  '".$setlist."'".
                " ,  `notes` =  '".$notes."'".
                " ,  `lastmodified` =  NOW()".
                " ,  `sourcenotes` =  '".$sourcenotes."'".
                " ,  `taper` =  '".$taper."'".
                " ,  `transferer` =  '".$transferer."'".
                " ,  `sourceidentification` =  '".$sourceidentification."'".
                " ,  `sumlength` = ".$sumlength.
                " ,  `summedia` = ".$summedia.
                " ,  `visible` = ".$isVisible.
                "  WHERE `id` = '".$recordingId."';";
        mysql_query($sql) or die(mysql_error());
    }

    static function modifyRecord($recordingId) {
        $sql = "UPDATE `recordings` SET  ".
                "  `lastmodified` =  NOW()".
                "  WHERE `id` = '".$recordingId."';";
        mysql_query($sql) or die(mysql_error());
    }

    /**
     * sets the creation date to the current date.
     * this means this record appears agai inth news list
     */
    static function upgradeRecord($recordingId) {
        $sql = "UPDATE `recordings` SET  `created` =  NOW() WHERE `id` = '$recordingId';";
        mysql_query($sql) or die(mysql_error());
    }

    public static function createRecordAndGetId($concertId) {
        $sqlInsertNewRecording = "INSERT INTO recordings (concerts_id,created) VALUES (" . $concertId . ",NOW());";
        mysql_query($sqlInsertNewRecording) or die("MySQL-Error: " . mysql_error());
        $recordingId = mysql_insert_id();
        return $recordingId;
    }

    public static function createVideoAndGetId($recordingId) {
        $sqlInsertNewVideo = "INSERT INTO video (recordings_id) VALUES (" . $recordingId . ");";
        mysql_query($sqlInsertNewVideo) or die("MySQL-Error: " . mysql_error());
        $videoId = mysql_insert_id();
        return $videoId;
    }

    public static function createAudioAndGetId($recordingId) {
        $sqlInsertNewAudio = "INSERT INTO audio (recordings_id) VALUES (" . $recordingId . ");";
        mysql_query($sqlInsertNewAudio) or die("MySQL-Error: " . mysql_error());
        $audioId = mysql_insert_id();
        return $audioId;
    }

    public static function changeConcertIdInRecord($recordId,$newConcertId) {
        $sql = "UPDATE recordings SET concerts_id =  $newConcertId  WHERE id=$recordId;";
        mysql_query($sql) or die(mysql_error());
        $msg= "altes record $recordId an neus concert $newConcertId gehangen";
        $stateMsgHandler= StateMsgHandler::getInstance();
        $stateMsgHandler->addStateMsg($msg);
    }
}
?>
