<?php
include_once "../constants.php";
include_once Constants :: getClassFolder() . "Linky.php";
include_once Constants :: getClassFolder() . "SublistMananger.php";
include_once Constants :: getLibsFolder() . 'Smarty/Smarty.class.php';
include_once Constants :: getFunctionsFolder() . 'function.getRelativePathTo.php';
include_once Constants :: getFunctionsFolder() . "function.deleteRecord.php";
include_once Constants :: getClassFolder() . "AdminList.php";

abstract class AbstractAdminList extends ContentPageSmarty {


    abstract function getListData($smarty,$linky);

    public function execute($smarty,$linky) {

        if (isset ($_POST['deleteBtn'])) {
            $chkRecIds = $_POST['chkRecId']; //Inhalt der Checkboxen
            if (count($chkRecIds) > 0) {
                deleteRecords($chkRecIds);
            }
        }

        $data=$this->getListData($smarty,$linky);

        $smarty->assign("relativeTemplatesPath", getRelativePathTo(Constants :: getTemplateFolder()));
        $adminList = new AdminList($data);
        $adminList->getList($smarty);
    }
}
?>
