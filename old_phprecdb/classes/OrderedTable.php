<?php
define("FORWARD", 1);
define("BACKWARD", 2);

class OrderedTable {

    private $tableName = null;
    private $recordIdColoumnName=null;

    function __construct($tableName,$recordIdColoumnName) {
        $this->tableName=$tableName;
        $this->recordIdColoumnName=$recordIdColoumnName;
    }

    function getLastOrderId($recordingId) {
        $row = mysql_fetch_array(mysql_query("SELECT max(order_id) as max_order_id FROM "
                .$this->tableName." WHERE ".$this->recordIdColoumnName."=".$recordingId));
        $nextOrderId = $row['max_order_id'];
        if (empty ($nextOrderId)) {
            return 0;
        } else {
            return $nextOrderId;
        }
    }

    public function order($sourceId, $direction) {

        $row = mysql_fetch_array(mysql_query("SELECT * FROM ".$this->tableName." WHERE id=".$sourceId));
        $id = $row[$this->recordIdColoumnName];
        $order_id = $row['order_id'];

        if ($direction == FORWARD) {
            $sqlQuery=" SELECT id,order_id" .
                    " FROM " .$this->tableName.
                    " WHERE order_id = (" .
                    " SELECT MIN( order_id )" .
                    " FROM " .$this->tableName.
                    " WHERE order_id >" . $order_id .
                    " AND ".$this->recordIdColoumnName." =" . $id . " )" .
                    " AND ".$this->recordIdColoumnName." =" . $id;
            $row = mysql_fetch_array(mysql_query($sqlQuery));
            $nextId = $row['id'];
            $nextOrderId = $row['order_id'];
        } else { //$direction==BACKWARD
            $sqlQuery=" SELECT id,order_id" .
            " FROM " .$this->tableName.
            " WHERE order_id = (" .
            " SELECT MAX( order_id )" .
            " FROM " .$this->tableName.
            " WHERE order_id <" . $order_id .
            " AND ".$this->recordIdColoumnName." =" . $id . " )" .
            " AND ".$this->recordIdColoumnName." =" . $id;

            $row = mysql_fetch_array(mysql_query($sqlQuery));
            $nextId = $row['id'];
            $nextOrderId = $row['order_id'];
        }

        $stateMsgHandler=StateMsgHandler::getInstance();

        if (!empty ($nextId)) {
            self::changeOrderInDb($sourceId, $nextId, $order_id, $nextOrderId);
            $stateMsgHandler->addStateMsg("ordering successful");
        } else {
            $stateMsgHandler->addStateMsg("error ordering");
        }
    }

    private function changeOrderInDb($id1, $id2, $orderId1, $orderId2) {
        $sqlUpdate1 = "UPDATE ".$this->tableName." SET order_id=" . $orderId1 . " where id=" . $id2;
        mysql_query($sqlUpdate1) or die("MySQL-Error: " . mysql_error());

        $sqlUpdate2 = "UPDATE ".$this->tableName." SET order_id=" . $orderId2 . " where id=" . $id1;
        mysql_query($sqlUpdate2) or die("MySQL-Error: " . mysql_error());
    }
}
?>
