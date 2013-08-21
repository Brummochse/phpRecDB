<?php
include_once "CustomListData.php";
include_once Constants :: getClassFolder() . "SublistMananger.php";

class SubListData extends CustomListData {

    private $subListId;

    function SubListData($bootlegType,$subListId,$hideInvisibleRecords=true) {
        $this->subListId=$subListId;
        parent :: CustomListData($bootlegType,$hideInvisibleRecords);
    }

    protected function createQueryBuilder() {
        $queryData = parent :: createQueryBuilder();
        $queryData->addFromExtension("INNER JOIN  sublists ON sublists.recordings_id = recordings.id");
        $queryData->addWhereExtension('lists_id='.$this->subListId);
        return $queryData;
    }

    public function getListName() {
        $sublistMananger = new SublistMananger();
        $subListName=$sublistMananger->getListNameById($this->subListId);
        return $subListName;
    }

}

?>
