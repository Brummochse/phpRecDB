<?php
include_once "../constants.php";
include_once Constants::getFunctionsFolder() . "function.getConcertInfo.php";
include_once Constants::getLibsFolder() . 'Smarty/Smarty.class.php';
include_once (Constants::getClassFolder() . "Linky.php");
include_once (Constants::getClassFolder() . "YoutubeManager.php");
include_once Constants::getClassFolder() . "Helper.php";
include_once Constants::getClassFolder() . "RecordManager.php";
include_once  Constants::getAdminFolder()."EditMenu.php";
include_once Constants :: getClassFolder() . "StateMsgHandler.php";

class ContentPage extends ContentPageSmarty {

    public function getPageTemplateFileName() {
        return "youtubeSamples.tpl";
    }

    private function extractYoutubeId($url) {
        $id=null;
        if (preg_match('%youtube\\.com/(.+)%', $url, $match)) {
            $match = $match[1];
            $replace = array("watch?v=", "v/", "vi/");
            $match = str_replace($replace, "", $match);
            $parameters=explode("&", $match);
            $id=$parameters[0];
        }
        if ($id==null || strlen($id)<=0) {
            $stateMsgHandler= StateMsgHandler::getInstance();
            $stateMsgHandler->addStateMsg("video id cannot parsed from youtube url");
            $id=null;
        }
        return $id;

    }

    public function execute($smarty,$linky) {

        $recordingId= Helper::getParamAsInt('id');
        if ($recordingId != null) {

            $youtubeMngr=new  YoutubeManager();

            if (isset ($_POST['sent'])) {
                if (isset ($_POST['youtubeUrl'])) {
                    $youtubeTitle = $_POST['youtubeTitle'];
                    $youtubeUrl = $_POST['youtubeUrl'];
                    
                    $youtubeId=$this->extractYoutubeId($youtubeUrl);
                    
                    if ($youtubeId!=null) {
                       $youtubeMngr->addYoutubeSample($youtubeTitle, $youtubeId, $recordingId);
                       RecordManager::modifyRecord($recordingId);
                    }
                }
            }

            if (isset ($_GET['youtubeId']) && isset ($_GET['action'])) {
                if ($_GET['action'] == "1") {
                    $youtubeMngr->deleteYoutubeSample($_GET['youtubeId']);
                }
                if ($_GET['action'] == "2") {
                    $youtubeMngr->orderBackward($_GET['youtubeId']);
                }
                if ($_GET['action'] == "3") {
                    $youtubeMngr->orderForward($_GET['youtubeId']);
                }
                RecordManager::modifyRecord($recordingId);
            }

            $smarty->assign("youtubeSamples", $youtubeMngr->getYoutubeSamples($recordingId));
            getConcertInfo($recordingId, true, $smarty);

            EditMenu::addEditMenuLinksToSmarty($smarty, $linky, $recordingId);

            $smarty->assign("relativeTemplatesPath", getRelativePathTo(Constants::getTemplateFolder()));
        }
    }
}
?>

