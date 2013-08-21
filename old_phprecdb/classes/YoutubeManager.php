<?php

include_once dirname(__FILE__) . "/../constants.php";
include_once Constants :: getClassFolder() . "OrderedTable.php";
include_once Constants :: getClassFolder() . "Helper.php";

class YoutubeManager {

    private $orderedTable=null;

    function __construct() {
        $this->orderedTable=new OrderedTable('youtubesamples','recordings_id');
    }

    public function addYoutubeSample($youtubeTitle,  $youtubeId,  $recordingId) {
        $youtubeTitle = mysql_real_escape_string($youtubeTitle);
        $youtubeId = mysql_real_escape_string($youtubeId);

        $orderId = $this->orderedTable->getLastOrderId($recordingId);
        $orderId++; //next order_id = last order_id + 1

        $sqlInsert = "INSERT INTO youtubesamples (recordings_id,title,youtubeId,order_id) VALUES (" . $recordingId . ",'" . $youtubeTitle . "','" . $youtubeId . "','" . $orderId . "');";
        mysql_query($sqlInsert) or die("MySQL-Error: " . mysql_error());
    }

    public function orderForward($screenshotId) {
        $this->orderedTable->order($screenshotId, FORWARD);
    }
    public function orderBackward($screenshotId) {
        $this->orderedTable->order($screenshotId, BACKWARD);
    }

      public function deleteYoutubeSample($youtubeSampletId) {
        mysql_query("DELETE FROM `youtubesamples` WHERE id=$youtubeSampletId") or die("MySQL-Error: " . mysql_error());
    }

    public function getYoutubeSamples($recordingId, $withLinks = false) {
        $result = mysql_query("SELECT * FROM `youtubesamples` WHERE recordings_id='$recordingId' ORDER BY order_id") or trigger_error(mysql_error());
        $youtubeSamples = array ();
        $linky=new Linky(Constants::getParamAdminMenuIndex());
        while ($row = mysql_fetch_array($result)) {
            foreach ($row AS $key => $value) {
                $row[$key] = stripslashes($value);
            }
            $youtubeSample = array (
                    'title' => $row['title'],
                    'url' => Helper::generateYoutubeSampleLink($row['youtubeId']),
                    'recordingId' => $recordingId,
                    'id' => $row['id'],
                    'deleteLink' => $linky->encryptName('youtube',
                    array (
                    'youtubeId' => $row['id'],
                    'id' => $recordingId,
                    'action' => 1
                    )
                    ), 'backwardLink' => $linky->encryptName('youtube', array (
                    'youtubeId' => $row['id'],
                    'id' => $recordingId,
                    'action' => 2
                    )), 'forwardLink' => $linky->encryptName('youtube', array (
                    'youtubeId' => $row['id'],
                    'id' => $recordingId,
                    'action' => 3
            )));
            $youtubeSamples[]=$youtubeSample;
        }
        return $youtubeSamples;
    }

}
?>
