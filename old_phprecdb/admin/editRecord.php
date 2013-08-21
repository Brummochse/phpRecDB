<?php
include_once "functions/SelectCreator.php";
include_once "../settings/dbConnection.php";
include_once "../constants.php";
include_once Constants::getFunctionsFolder()."function.getConcertInfo.php";
include_once  Constants::getFunctionsFolder()."function.evaluateBoolean.php";
include_once ('../libs/Smarty/Smarty.class.php');
include_once Constants::getClassFolder() . "Linky.php";
include_once Constants::getClassFolder() . "Helper.php";
include_once Constants::getClassFolder() . "SublistMananger.php";
include_once Constants::getClassFolder()."SignatureCreator.php";
include_once Constants::getClassFolder()."RecordManager.php";
include_once  Constants::getAdminFolder()."EditMenu.php";

class ContentPage extends ContentPageSmarty {

    public function getPageTemplateFileName() {
        return "editRecord.tpl";
    }

    private function getValueOrNull($key) {
        $value=$_POST[$key];
        if (empty ($value)) {
            return 'NULL';
        } else {
            return $value;
        }
    }

    public function execute($smarty,$linky) {

        dbConnect();

        $recordingId= Helper::getParamAsInt('id');
        if ($recordingId != null) {
            $isVideo = Helper::recordingIsVideo($recordingId);
            if (isset ($_POST['sent']) && $_POST['sent']=='editRecord') {
                foreach ($_POST AS $key => $value) {
                    $_POST[$key] = mysql_real_escape_string($value);
                }

                $tradestatus_id=$_POST['tradestatus_id'];
                $rectypes_id=$_POST['rectypes_id'];
                $sources_id=$_POST['sources_id'];
                $media_id=$_POST['media_id'];
                $quality=$this->getValueOrNull('quality');
                $setlist=$_POST['setlist'];
                $notes=$_POST['notes'];
                $sourcenotes=$_POST['sourcenotes'];
                $taper=$_POST['taper'];
                $transferer=$_POST['transferer'];
                $sourceidentification=$_POST['sourceidentification'];
                $sumlength=$this->getValueOrNull('sumlength');
                $summedia=$this->getValueOrNull('summedia');
                $bitrate=$this->getValueOrNull('bitrate');
                $isVisible = evaluateBoolean($_POST['visible']);

                RecordManager::updateRecord($tradestatus_id,$rectypes_id,$sources_id,$media_id,$quality,
                        $setlist,$notes,$sourcenotes,$taper,$transferer,$sourceidentification,$sumlength,
                        $summedia,$recordingId,$isVisible);

                if ($isVideo) {
                    $aspectratio_id= $_POST['aspectratio_id'];
                    $videoformat_id=$_POST['videoformat_id'];
                    $authorer=$_POST['authorer'];
                    RecordManager::updateVideo($aspectratio_id,$videoformat_id,$bitrate,$authorer,$recordingId);
                } else {
                    $frequence=$this->getValueOrNull('frequence');
                    RecordManager::updateAudio($frequence,$bitrate,$recordingId);
                }

                if (isset($_POST['upgrade']) && evaluateBoolean($_POST['upgrade']))
                {
                    RecordManager::upgradeRecord($recordingId);
                }

                RecordManager::modifyRecord($recordingId);

                $msg="record saved.";
                $stateMsgHandler= StateMsgHandler::getInstance();
                $stateMsgHandler->addStateMsg($msg);
            }
            $sqlSelect = "SELECT concerts_id, rectypes_id, sources_id, media_id, tradestatus_id, quality, setlist, notes, created, sourcenotes, taper, transferer, sourceidentification, sumlength, summedia,visible 
									FROM recordings WHERE id=" . $recordingId;
            $recInfo = mysql_fetch_array(mysql_query($sqlSelect)) or die("MySQL-Error: " . mysql_error());

            if ($isVideo) {
                $sqlSelect = "SELECT * FROM video WHERE recordings_id=" . $recordingId;
                $videoInfo = mysql_fetch_array(mysql_query($sqlSelect)) or die("MySQL-Error: " . mysql_error());
            } else { //isAudio
                $sqlSelect = "SELECT * FROM audio WHERE recordings_id=" . $recordingId;
                $audioInfo = mysql_fetch_array(mysql_query($sqlSelect)) or die("MySQL-Error: " . mysql_error());
            }

            getConcertInfo($recordingId, true, $smarty);

            EditMenu::addEditMenuLinksToSmarty($smarty, $linky, $recordingId);

            $smarty->assign('recordingId', $recordingId);
            $smarty->assign('sourceidentification', stripslashes($recInfo['sourceidentification']));
            $smarty->assign('quality', stripslashes($recInfo['quality']));
            $smarty->assign('sumlength', stripslashes($recInfo['sumlength']));
            $smarty->assign('summedia', stripslashes($recInfo['summedia']));
            $smarty->assign('setlist', stripslashes($recInfo['setlist']));
            $smarty->assign('notes', stripslashes($recInfo['notes']));
            $smarty->assign('sourcenotes', stripslashes($recInfo['sourcenotes']));
            $smarty->assign('taper', stripslashes($recInfo['taper']));
            $smarty->assign('transferer', stripslashes($recInfo['transferer']));
            $smarty->assign('tradestatus', createSelectBox("tradestatus_id", "tradestatus", "id", "label", $recInfo['tradestatus_id']));
            $smarty->assign('visible', stripslashes($recInfo['visible']));


            if ($isVideo) {
                $smarty->assign('authorer', stripslashes($videoInfo['authorer']));
                $smarty->assign('videoformat', createSelectBox("videoformat_id", "videoformat", "id", "label", $videoInfo['videoformat_id']));
                $smarty->assign('bitrate', stripslashes($videoInfo['bitrate']));
                $smarty->assign('aspectratio', createSelectBox("aspectratio_id", "aspectratio", "id", "label", $videoInfo['aspectratio_id']));
                $smarty->assign('videoOrAudio', 'video');
                $bootlegTypeId="1";
            } else {
                $smarty->assign('frequence', stripslashes($audioInfo['frequence']));
                $smarty->assign('bitrate', stripslashes($audioInfo['bitrate']));
                $smarty->assign('videoOrAudio', 'audio');
                $bootlegTypeId="2";
            }
            $smarty->assign('rectypes', createSelectBox("rectypes_id", "rectypes", "id", "label", $recInfo['rectypes_id'], $bootlegTypeId));
            $smarty->assign('sources', createSelectBox("sources_id", "sources", "id", "label", $recInfo['sources_id'], $bootlegTypeId));
            $smarty->assign('media', createSelectBox("media_id", "media", "id", "label", $recInfo['media_id'], $bootlegTypeId));
            $smarty->assign("relativeTemplatesPath", getRelativePathTo(Constants::getTemplateFolder()));

            $this->chargeSublistInformation($recordingId,$smarty,$linky);

            SignatureCreator::updateSignature();
        }


    }

    function chargeSublistInformation($recordingId,$smarty,$linky) {
        $sublistMananger=new SublistMananger();

        if (isset ($_POST['sent']) && $_POST['sent']=='sublist') {
            $listId = $_POST['sublist_id'];
            if ($listId!=null) {
                $sublistMananger->moveToSubList(array($recordingId),$listId);
            }
        }

        if (isset ($_POST['delete']) ) {
            $listDeleteId=$_POST['delete'];
            $sublistMananger->removeFromSubList(array($recordingId),$listDeleteId);
        }

        $relatedSublists= $sublistMananger->getRelatedSublists($recordingId);
        $smarty->assign('relatedSublists',$relatedSublists);

        $deleteLink=$linky->encryptName('edit Record',array("id"=>$recordingId))."&delete=";
        $smarty->assign('deleteLink',$deleteLink);

        $smarty->assign('sublists', $sublistMananger->getLists());
    }

}
?> 