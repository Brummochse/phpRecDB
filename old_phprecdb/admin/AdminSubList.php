<?php
include_once "AbstractAdminList.php";
include_once Constants :: getClassFolder() . "SubListData.php";


class ContentPage extends AbstractAdminList {

    public function getPageTemplateFileName() {
        return "adminSubList.tpl";
    }

    public function getListData($smarty,$linky) {
        $sublistMananger = new SublistMananger();
        $decryptedPageName = $linky->decryptName();
        $subListId = $sublistMananger->getListIdByName($decryptedPageName);

        if (isset ($_POST['removeFromSublistBtn'])) {
            $chkRecIds = $_POST['chkRecId']; //Inhalt der Checkboxen

            if (count($chkRecIds) > 0) {
                $sublistMananger->removeFromSubList($chkRecIds, $subListId);
            }
        }
       
        return new SubListData(VIDEO_AND_AUDIO, $subListId,false);
    }

}
?>



