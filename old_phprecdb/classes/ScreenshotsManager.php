<?php
include_once dirname(__FILE__) . "/../constants.php";
include_once Constants :: getClassFolder() . "OrderedTable.php";
include_once Constants :: getClassFolder() . "Linky.php";

class ScreenshotsManager {

    private $orderedTable=null;

    function __construct() {
        $this->orderedTable=new OrderedTable('screenshot','video_recordings_id');
    }


    public function addNewScreenshot($recordingId, $newImagefilename, $newThumbnailFilename) {
        $newImagefilename = mysql_real_escape_string($newImagefilename);
        $newThumbnailFilename = mysql_real_escape_string($newThumbnailFilename);

        $orderId = $this->orderedTable->getLastOrderId($recordingId);
        $orderId++; //next order_id = last order_id + 1

        $sqlInsert = "INSERT INTO screenshot (video_recordings_id,screenshot_filename,thumbnail,order_id) VALUES (" . $recordingId . ",'" . $newImagefilename . "','" . $newThumbnailFilename . "','" . $orderId . "');";
        mysql_query($sqlInsert) or die("MySQL-Error: " . mysql_error());
    }

    public function deleteScreenshot($screenshotId, $screenshotFolder) {
        $row = mysql_fetch_array(mysql_query("SELECT * FROM `screenshot` WHERE `id` = $screenshotId ")) or die("MySQL-Error: " . mysql_error());

        $screenshotFile = stripslashes($row['screenshot_filename']);
        $thumbnailFile = stripslashes($row['thumbnail']);

        if ((!empty ($screenshotFile)) && (!empty ($thumbnailFile))) {
            if (file_exists($screenshotFolder . $screenshotFile)) {
                unlink($screenshotFolder . $screenshotFile);
            }
            if (file_exists($screenshotFolder . $thumbnailFile)) {
                unlink($screenshotFolder . $thumbnailFile);
            }
        }
        mysql_query("DELETE FROM `screenshot` WHERE id=$screenshotId") or die("MySQL-Error: " . mysql_error());
    }

    public function orderForward($screenshotId) {
        $this->orderedTable->order($screenshotId, FORWARD);
    }
    public function orderBackward($screenshotId) {
        $this->orderedTable->order($screenshotId, BACKWARD);
    }

    public static function generateScreenshotName($recordId) {
        $infos=getConcertInfoAsArray($recordId);
        $artist=$infos["artist"];
        $date=$infos["date"];

        $screenshotname=$artist."_".$date;
        $screenshotname=ScreenshotsManager::removeEvilChars($screenshotname);
        $screenshotname=ScreenshotsManager::convertSpaces($screenshotname);
        return $screenshotname;
    }

    private static function removeEvilChars($string) {
        $patterns = array(
                "/\\&/",  # Kaufmaennisches UND
                "/\\</",  # < Zeichen
                "/\\>/",  # > Zeichen
                "/\\?/",  # ? Zeichen
                "/\"/",   # " Zeichen
                "/\\:/",  # : Zeichen
                "/\\|/",  # | Zeichen
                "/\\\\/", # \ Zeichen
                "/\\//",  # / Zeichen
                "/\\*/"   # * Zeichen
        );
        return  preg_replace( $patterns, '', $string );
    }

    private static function convertSpaces($string) {
        $patterns = array(
                "/\\s/",  # Leerzeichen
        );
        return  preg_replace( $patterns, '_', $string );
    }

    public function getScreenshotsData($recordingId, $screenshotFolder, $smarty, $withLinks = false) {
        $result = mysql_query("SELECT * FROM `screenshot` WHERE video_recordings_id='$recordingId' ORDER BY order_id") or trigger_error(mysql_error());
        $screenshots = array ();
        $linky=new Linky(Constants::getParamAdminMenuIndex());
        while ($row = mysql_fetch_array($result)) {
            foreach ($row AS $key => $value) {
                $row[$key] = stripslashes($value);
            }
            $screenshot = array (
                    'screenshot_filename' => $screenshotFolder . $row['screenshot_filename'],
                    'thumbnail' => $screenshotFolder . $row['thumbnail'],
                    'recordingId' => $recordingId,
                    'id' => $row['id'],
                    'deleteLink' => $linky->encryptName('screenshots',
                    array (
                    'screenshotId' => $row['id'],
                    'id' => $recordingId,
                    'action' => 1
                    )
                    ), 'backwardLink' => $linky->encryptName('screenshots', array (
                    'screenshotId' => $row['id'],
                    'id' => $recordingId,
                    'action' => 2
                    )), 'forwardLink' => $linky->encryptName('screenshots', array (
                    'screenshotId' => $row['id'],
                    'id' => $recordingId,
                    'action' => 3
                    )));
            array_push($screenshots, $screenshot);
        }
        $smarty->assign('screenshots', $screenshots);
    }
}

?>
