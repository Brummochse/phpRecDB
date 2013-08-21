<?php
include_once "CustomListData.php";

//lastNewsType
define("LAST_RECORDS", 1);
define("LAST_DAYS", 2);
define("LAST_RECORDS_PER_DAY", 3);

class NewsListData extends CustomListData {

    private $newsCount;
    private $lastNewsType;

    function NewsListData($bootlegType, $newsCount = 5, $lastNewsType = LAST_DAYS) {
        parent :: CustomListData($bootlegType);
        $this->newsCount = $newsCount;
        $this->lastNewsType = $lastNewsType;
    }

    public function getListName() {
        return "News";
    }

    protected function createQueryBuilder() {
        $queryData = parent :: createQueryBuilder();
        if ($this->lastNewsType == LAST_DAYS) {
            $queryData->addSelectExtension('date(recordings.created) AS createdDate');
            $lastDate = $this->evaluateLastDate($this->newsCount);
            $queryData->addWhereExtension("recordings.created>='" . $lastDate . "'");
            $queryData->addOrderbyExtension("createdDate DESC");
        }
        if ($this->lastNewsType == LAST_RECORDS_PER_DAY) {
            $queryData->addSelectExtension('date(recordings.created) AS createdDate');
            $queryData->setLimit($this->newsCount);
            $queryData->addOrderbyExtension("createdDate DESC");
        }
        if ($this->lastNewsType == LAST_RECORDS) {
            $queryData->setLimit($this->newsCount);
            $queryData->addOrderbyExtension("recordings.created DESC");
        }
        return $queryData;
    }

    public function evaluateLastDate($newsCount) {
        $newsCount = (int) $newsCount;

        $selectBase = "SELECT " .
                "DISTINCT date(recordings.created) AS creationDate  ";

        $fromBase = " FROM concerts" .
                " LEFT OUTER JOIN recordings ON concerts.id = recordings.concerts_id ";

        $orderbyBaseStart = " ORDER BY creationDate DESC ";

        $orderbyBaseEnd = '';

        $queryBuilder = new SqlQueryBuilder($selectBase, $fromBase, $orderbyBaseStart, $orderbyBaseEnd);
        $queryBuilder->setLimit($newsCount);

        $this->chargeQueryBuilder($queryBuilder);
        $queryBuilder->clearSelectExtensions();
        $sqlSelect = $queryBuilder->getQuery();

        $updateDates = mysql_query($sqlSelect) or die("MySQL-Error: " . mysql_error());
        while ($date = mysql_fetch_row($updateDates)) {
            $oldestDate = $date[0];
        }
        return $oldestDate;
    }

}

?>
