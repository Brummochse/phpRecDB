<?php
session_start();

include_once "../constants.php";
include_once Constants :: getLibsFolder() . "SimpleMember/adminpro_class.php";
$prot = new protect("0", "1");
if ($prot->showPage) {
    $curUser = $prot->getUser();

    //update Database... needed when there was a script update which need to update database too
    include_once Constants :: getClassFolder() . "DbUpdater.php";
    include_once Constants :: getClassFolder() . "StateMsgHandler.php";
    include_once Constants :: getLibsFolder() . 'Smarty/Smarty.class.php';
    include_once Constants :: getAdminFolder() . "AbstractContentPage.php";

    $dbUpdater = new DbUpdater();
    $stateMsgHandler = StateMsgHandler :: getInstance();

    $smarty = new Smarty;
    $smarty->template_dir = Constants :: getTemplateFolder();
    $smarty->compile_dir = Constants :: getCompileFolder();

    //does nothing when the database is already up-to-date
    if ($dbUpdater->update() == true) {
        $msg = "Database updated to new Version:" . $dbUpdater->getLatestDbVersion();
        $stateMsgHandler->addStateMsg($msg);
    }

    //menu bar
    include "menu.php";

    //show currently logged in user
    $smarty->assign('userName', $curUser);


    //evaluate which contentpage is selected and display it
    $linky = new Linky(Constants::getParamAdminMenuIndex());
    $link = $linky->decryptLink();

    if (!empty ($link)) {
        include $link;
    } else {
        include Constants :: getAdminFolder() . "about.php";
    }

    $contentPage=new ContentPage();
    $contentPage->chargeSmarty($smarty,$linky);

    //state messages displaying

    $smarty->assign('stateMsgs', $stateMsgHandler->getStateMsgs());
    $smarty->display(Constants :: getTemplateFolder() . "admin/indexAdmin.tpl");

}
?>
