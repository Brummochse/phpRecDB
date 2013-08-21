<?php
class ContentPage extends ContentPageSmarty {

    public function getPageTemplateFileName() {
        return "about.tpl";
    }

    public function execute($smarty,$linky) {
        include_once dirname(__FILE__) . "/../constants.php";
        include_once Constants :: getClassFolder() . "DbUpdater.php";
        
        $dbUpdater = new DbUpdater();

        $smarty->assign('dbVersion', $dbUpdater->getCurrentDbVersion());
        $smarty->assign('scriptVersion', Constants::getScriptVersion());
    }

}
?>