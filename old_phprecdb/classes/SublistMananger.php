<?php
include_once dirname(__FILE__) . "/../constants.php";
include_once Constants :: getClassFolder() . "StateMsgHandler.php";

class SublistMananger {

    public function SublistMananger() {
        include_once dirname(__FILE__) . "/../settings/dbConnection.php";
        dbConnect();
    }

    public function getListIdByName($listName) {
        $lists = $this->getLists();
        foreach ($lists as $id => $name) {
            if ($name == $listName) {
                return $id;
            }
        }
        return null;
    }

    public function getListNameById($listId) {
        $lists = $this->getLists();
        foreach ($lists as $id => $name) {
            if ($id == $listId) {
                return $name;
            }
        }
        return null;
    }

    public function getLists() {
        $sqlSelect = "SELECT id,label FROM `lists`";
        $sqlResultLists = mysql_query($sqlSelect) or die("MySQL-Error: " . mysql_error());

        $lists = array ();
        while ($list = mysql_fetch_row($sqlResultLists)) {
            $lists[$list[0]] = $list[1];
        }
        return $lists;
    }

    public function getRelatedSublists($recordingId) {
        $sqlSelect = "SELECT lists_id FROM `sublists` WHERE recordings_id=".$recordingId;
        $sqlResultLists = mysql_query($sqlSelect) or die("MySQL-Error: " . mysql_error());

        $relatedSublists = array ();
        while ($listidRow = mysql_fetch_row($sqlResultLists)) {
            $listid=$listidRow[0];
            $relatedSublists[$listid] = $this->getListNameById($listid);
        }
        return $relatedSublists;
    }

    public function moveToSubList($recordIds, $sublistId) {
        $sqlQuery = "INSERT IGNORE INTO sublists (" .
                "`recordings_id` ," .
                "`lists_id`" .
                ")" .
                "VALUES ('" . implode($recordIds, "','" . $sublistId . "'),('") . "','". $sublistId ."');";
        mysql_query($sqlQuery) or die(mysql_error());

        $msg = "added shows with id:" . implode($recordIds, ", ") . " to sublist: " .$sublistId;
        $stateMsgHandler = StateMsgHandler :: getInstance();
        $stateMsgHandler->addStateMsg($msg);
    }

    public function removeFromSubList($recordIds, $sublistId) {
        $sqlQuery = "DELETE FROM sublists" .
                " WHERE sublists.lists_id = " . $sublistId . " AND " .
                "(recordings_id =" . implode($recordIds, ' OR recordings_id=') . ")";

        mysql_query($sqlQuery) or die(mysql_error());

        $msg = "shows with id:" . implode($recordIds, ", ") . " removed from sublist:" . $subListId;
        $stateMsgHandler = StateMsgHandler :: getInstance();
        $stateMsgHandler->addStateMsg($msg);
    }

}
?>
