<?php
function getInfoPage($recordingId) {
    include_once dirname(__FILE__) . "/../constants.php";
    include_once Constants::getLibsFolder().'Smarty/Smarty.class.php';
    include_once Constants::getSettingsFolder().'dbConnection.php';
    include_once Constants::getFunctionsFolder()."function.getConcertInfo.php";
    include_once Constants::getClassFolder()."ScreenshotsManager.php";
    include_once Constants::getClassFolder()."YoutubeManager.php";
    include_once Constants::getFunctionsFolder() . 'function.getRelativePathTo.php';
    dbConnect();

    $sqlSelect = "SELECT  recordings.sumlength," .
            "media.label," .
            "rectypes.label," .
            "sources.label," .
            "recordings.quality," .
            "tradestatus.label," .
            "recordings.created," .
            "recordings.lastmodified," .
            "recordings.summedia," .
            "recordings.sourcenotes," .
            "recordings.taper," .
            "recordings.transferer," .
            "recordings.setlist," .
            "recordings.notes " .
            "FROM recordings " .
            "LEFT OUTER JOIN media ON media.id = recordings.media_id " .
            "LEFT OUTER JOIN rectypes ON rectypes.id = recordings.rectypes_id " .
            "LEFT OUTER JOIN sources ON sources.id = recordings.sources_id " .
            "LEFT OUTER JOIN tradestatus ON tradestatus.id = recordings.tradestatus_id " .
            "WHERE recordings.id=" . $recordingId;
    $sqlResult = mysql_query($sqlSelect) or die("MySQL-Error: " . mysql_error());
    $recordingInfo = mysql_fetch_row($sqlResult);

    $sumLength = $recordingInfo[0];
    $medium = $recordingInfo[1];
    $rectype = $recordingInfo[2];
    $source = $recordingInfo[3];
    $quality = $recordingInfo[4];
    $tradestatus = $recordingInfo[5];
    $created = $recordingInfo[6];
    $lastmodified = $recordingInfo[7];
    $sumMedia = $recordingInfo[8];
    $sourcenotes = stripslashes($recordingInfo[9]);
    $taper = stripslashes($recordingInfo[10]);
    $transferer = stripslashes($recordingInfo[11]);
    $setlist = stripslashes($recordingInfo[12]);
    $notes = stripslashes($recordingInfo[13]);

    if (!empty ($sumLength))
        $sumLength = $sumLength . " min";
    if (!empty ($quality))
        $quality = $quality . "/10";

    $smarty = new Smarty;
    $smarty->template_dir = Constants::getTemplateFolder();
    $smarty->compile_dir = Constants::getCompileFolder();


    if (recordingIsVideo($recordingId)) {
        $bootlegType = '1';
        $sqlSelect = "SELECT authorer,video.bitrate,videoformat.label,aspectratio.label FROM video ".
                "LEFT OUTER JOIN videoformat ON videoformat.id = video.videoformat_id ".
                "LEFT OUTER JOIN aspectratio ON aspectratio.id = video.aspectratio_id "
                ."WHERE recordings_id=" . $recordingId;
        $videoInfo = mysql_fetch_array(mysql_query($sqlSelect)) or die("MySQL-Error: " . mysql_error());

        $smarty->assign('authorer', stripslashes($videoInfo[0]));
        $smarty->assign('videoformat',$videoInfo[2]);
        $smarty->assign('bitrate', stripslashes($videoInfo[1]));
        $smarty->assign('aspectratio', $videoInfo[3]);

        $screenshotMngr=new ScreenshotsManager();
        $screenshotMngr->getScreenshotsData($recordingId, getRelativePathTo(Constants::getScreenshotsFolder()), $smarty);

        $youtubeMngr=new YoutubeManager();
        $smarty->assign("youtubeSamples", $youtubeMngr->getYoutubeSamples($recordingId));

    } else {
        $bootlegType = '2';
        $sqlSelect = "SELECT * FROM audio WHERE recordings_id=" . $recordingId;
        $audioInfo = mysql_fetch_array(mysql_query($sqlSelect)) or die("MySQL-Error: " . mysql_error());

        $smarty->assign('frequence', stripslashes($audioInfo['frequence']));
        $smarty->assign('bitrate', stripslashes($audioInfo['bitrate']));
    }

    getConcertInfo($recordingId, true, $smarty);

    $smarty->assign("tradestatus", $tradestatus);
    $smarty->assign("lastmodified", $lastmodified);
    $smarty->assign("created", $created);
    $smarty->assign("sumlength", $sumLength);
    $smarty->assign("quality", $quality);
    $smarty->assign("rectype", $rectype);
    $smarty->assign("medium", $medium);
    $smarty->assign("summedia", $sumMedia);
    $smarty->assign("source", $source);
    $smarty->assign("sourcenotes", $sourcenotes);
    $smarty->assign("taper", $taper);
    $smarty->assign("transferer", $transferer);
    $smarty->assign("setlist", nl2br($setlist));
    $smarty->assign("notes", nl2br($notes));

    $smarty->assign("relativeTemplatesPath", getRelativePathTo(Constants::getTemplateFolder()));
    $smarty->display(Constants::getTemplateFolder() . "info.tpl");
}

function recordingIsVideo($recordingId) {
    $sqlSelect = "SELECT id FROM `video` WHERE recordings_id=" . $recordingId;
    $results = mysql_query($sqlSelect) or die("MySQL-Error: " . mysql_error());
    return mysql_num_rows($results) == 1;
}
?>
