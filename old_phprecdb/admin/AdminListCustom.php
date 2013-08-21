<?php
include_once "AbstractAdminList.php";
include_once Constants :: getClassFolder() . "CustomListData.php";

class AdminListCustom extends AbstractAdminList {

    private $bootlegType = "";

    public function __construct($bootlegType) {
        $this->bootlegType=$bootlegType;
    }

    public function getPageTemplateFileName() {
        return "adminList.tpl";
    }

    public function getListData($smarty,$linky) {
        $sublistMananger = new SublistMananger();
        if (isset ($_POST['moveToSublistBtn'])) {
            $chkRecIds = $_POST['chkRecId']; //Inhalt der Checkboxen
            $listId = $_POST['sublist_id'];

            if (count($chkRecIds) > 0) {
                $sublistMananger->moveToSubList($chkRecIds, $listId);

            }
        }
        $smarty->assign('sublists', $sublistMananger->getLists());
        return  new CustomListData($this->bootlegType,false);

    }
}
?>

