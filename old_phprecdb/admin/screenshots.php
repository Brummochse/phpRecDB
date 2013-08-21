<?php
include_once "../constants.php";
include_once Constants::getSettingsFolder() . "dbConnection.php";
include_once Constants::getClassFolder()."ScreenshotsManager.php";
include_once Constants::getFunctionsFolder() . "function.getConcertInfo.php";
include_once Constants::getLibsFolder() . 'Smarty/Smarty.class.php';
include_once (Constants::getClassFolder() . "Linky.php");
include_once (Constants::getClassFolder() . "ScreenshotUploader.php");
include_once Constants::getClassFolder() . "Helper.php";
include_once Constants::getClassFolder() . "RecordManager.php";
include_once  Constants::getAdminFolder()."EditMenu.php";

class ContentPage extends ContentPageSmarty {

    public function getPageTemplateFileName() {
        return "screenshots.tpl";
    }

    public function execute($smarty,$linky) {
        dbConnect();

        $recordingId= Helper::getParamAsInt('id');
        if ($recordingId != null) {

            $screenshotMngr=new ScreenshotsManager();

            if (isset ($_POST['sent'])) {
                $uploader = new ScreenshotUploader();
                if ($uploader->uploadFile("screenshot",$recordingId)) {
                    $screenshotMngr->addNewScreenshot($recordingId, $uploader->getNewImagefilename(), $uploader->getNewThumbnailFilename());
                    RecordManager::modifyRecord($recordingId);
                }
            }

            if (!isset ($_POST['sent']) && isset ($_GET['screenshotId']) && isset ($_GET['action'])) {
                if ($_GET['action'] == "1") {
                    $screenshotMngr->deleteScreenshot($_GET['screenshotId'], "../screenshots/");
                }
                if ($_GET['action'] == "2") {
                    $screenshotMngr->orderBackward($_GET['screenshotId']);
                }
                if ($_GET['action'] == "3") {
                    $screenshotMngr->orderForward($_GET['screenshotId']);
                }
                RecordManager::modifyRecord($recordingId);
            }

            $screenshotMngr->getScreenshotsData($recordingId, "../screenshots/", $smarty, true);
            getConcertInfo($recordingId, true, $smarty);
            EditMenu::addEditMenuLinksToSmarty($smarty, $linky, $recordingId);
            $smarty->assign("relativeTemplatesPath", getRelativePathTo(Constants::getTemplateFolder()));
        }
    }
}
?>

