<?php
include_once dirname(__FILE__) . "/../constants.php";
include_once Constants::getClassFolder() . "SettingsManager.php";

class ContentPage extends ContentPageSmarty {

    public function getPageTemplateFileName() {
        return "screenCompr.tpl";
    }

    public function execute($smarty,$linky) {
        foreach ($_POST AS $key => $value) {
            $_POST[$key] = mysql_real_escape_string($value);
        }

        $settingsManager = new SettingsManager();

        if (isset ($_POST['submitted'])) {
            $isCompr = $_POST['compr'];
            $settingsManager->setPropertyValue('screenshot_compression', $isCompr);
        } else {
            $isCompr = $settingsManager->getPropertyValue('screenshot_compression');
        }

        $smarty->assign('compr', array (
                "1" => " compress to JPG (recommended)",
                "0" => " do NOT compress, leave like it is"
        ));
        $smarty->assign('compr_id', $isCompr);
    }



}
?>
