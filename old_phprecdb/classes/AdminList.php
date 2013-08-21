<?php
include_once "ListBuilderPro.php";
include_once dirname(__FILE__) . "/../constants.php";
include_once Constants :: getClassFolder() . "Helper.php";
include_once Constants :: getFunctionsFolder() . "function.deleteRecord.php";

class AdminList extends ListBuilderPro {

    private $linky;

    function AdminList($data) {
        $this->linky = new Linky(Constants::getParamAdminMenuIndex());
        parent :: ListBuilderPro($data);

        $deleteRecordId=Helper::getParamAsInt("delete");
        if (! empty ($deleteRecordId)) {
            unset($_GET["delete"]);
            deleteRecord($deleteRecordId);

        }
    }

    function getEditLink($recordingsId) {
        $url = $this->linky->encryptName('edit Record', array (
                'id' => $recordingsId
        ));
        $link = "<a href='$url'>edit</a>";
        return $link;
    }

    function getDeleteLink($recordingsId) {
        $link = "<a href=\"javascript:deleteRecord('" .
                $this->linky->encryptName($this->linky->decryptName(), array (
                'delete' => $recordingsId
                )) . "')\">delete</a>";

        return $link;
    }

    function getPrintinfoLink($recordingsId) {
        $printInfoURL = "PrintInfo.php";
        $param = "?id=$recordingsId";
        $url = $printInfoURL . $param;
        $link = "<a target='_blank' href='$url' onclick='javascript:pop(this.href,1,373,560); return false'>PrintInfo</a>";

        return $link;
    }

    function getCheckbox($recordingsId,$artistsId) {
        return "<input type='checkbox' class='".$artistsId."' name='chkRecId[]' value='$recordingsId'>";
    }

    protected function getButtons($recordingId,$artistsId) {
        return $this->getEditLink($recordingId) . " " . $this->getDeleteLink($recordingId) . " " . $this->getPrintinfoLink($recordingId) . " " . $this->getCheckbox($recordingId,$artistsId);
    }

    protected function getArtistHtml($artistId) {
        return "<input type='button' value='select all' onclick='javascript:selectAll(".$artistId.")'>".
        "<input type='button' value='deselect all' onclick='javascript:deselectAll(".$artistId.")'>";
    }

}

?>