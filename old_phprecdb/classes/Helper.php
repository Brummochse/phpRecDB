<?php
class Helper {

    public static function getParamAsInt($key) {
        if (isset ($_GET[$key])) {
            $intParam = (int) $_GET[$key];
            if (!empty ($intParam)) {
                return $intParam;
            }
        }
        return null;
    }

    public static function makeUrl($params = array ()) {
        $get = $GLOBALS['_GET'];

        foreach ($params as $paramName=>$paramValue) {
            if ($paramValue==null) {
                if (isset($get[$paramName])) {
                    unset($get[$paramName]);
                }
            } else {
                $get[$paramName]=$paramValue;
            }
        }

        $ga = array ();
        foreach ($get as $k => $v) {
            if (is_array($v)) continue;
            $ga[] = urlencode($k) . "=" . urlencode($v);
        }
        //
        return basename($GLOBALS['_SERVER']['PHP_SELF']) . "?" . implode("&", $ga);
    }


    public static function recordingIsVideo($recordingId) {
        $sqlSelect = "SELECT id FROM `video` WHERE recordings_id=" . $recordingId;
        $results = mysql_query($sqlSelect) or die("MySQL-Error: " . mysql_error());
        return mysql_num_rows($results) == 1;
    }

    public static function generateYoutubeSampleLink($youtubeId) {
        return 'http://www.youtube.com/v/'.$youtubeId;
    }

}
?>
