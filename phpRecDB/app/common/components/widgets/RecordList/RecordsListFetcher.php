<?php

class RecordsListFetcher {

    const DATA_PROVIDER = 'dataProvider';
    const COLUMNS = 'columns';
    const ARTIST_ITEMS = 'artistItems';

    private $config;
    private $columnStock;

    public function __construct($listDataConfig) {
        $this->config = $listDataConfig;
    }

    public function getData() {
        $data = array();

        $data[self::DATA_PROVIDER] = NULL;
        $data[self::COLUMNS] = NULL;
        if ($this->config->isRecordListVisible()) {
            $this->columnStock = new ColumnStock();
            $dataProvider = $this->getListDataProvider();
            $data[self::DATA_PROVIDER] = $dataProvider;
            $data[self::COLUMNS] = $this->columnStock->getColDefinitions($dataProvider, $this->config->isAdmin());
        }
        //
        $data[self::ARTIST_ITEMS] = $this->getArtistData();

        return $data;
    }

    /**
     * combines conditions for a sql where-clause with a AND's
     * 
     * @param type $andParts
     * @param type $generateWhere if true, the WHERE-keyword gets generated
     * @return string
     */
    private function createWhereClause($andParts, $generateWhere = false) {
        $whereClause = implode(" AND ", $andParts);

        if (strlen($whereClause) > 0 && $generateWhere) {
            $whereClause = " WHERE " . $whereClause;
        }
        return $whereClause;
    }

    private function getListDataProvider() {

        $additionalCols=$this->config->getAdditionalRecordListCols();
        $cols=$this->columnStock->getQueryBuilderSettings($additionalCols);
        //
        $sourceModelName = "Record";
        $queryBuilder = new QueryBuilderAdapter();
        $query = $queryBuilder->buildQueryString($sourceModelName, $cols);

        //add where clause to query
        $query.=$this->createWhereClause($this->config->getRecordListFilters(), true);

        //
        $sort = new CSort;
        $sort->attributes = $this->config->getSortAttributes();
        $sort->defaultOrder = $this->config->getDefaultOrder();

        $dataProvider = new CSqlDataProvider($query, array(
            'pagination' => false,
            'sort' => $sort,
        ));
        return $dataProvider;
    }

    ///////////////////////////////////////////////////////
    //Artstfetcher

    private function getArtists() {
        $cols = array(
            "" => array("id"),
            "artist" => array("name as Artist", "id as ArtistId"),
            "records" => array("id as RecordId"),
        );

        //add additional cols
        $cols = array_merge_recursive($cols, $this->config->getAdditionalArtistMenuCols());

        //
        $sourceModelName = "Concert";
        $queryBuilder = new QueryBuilderAdapter();

        $queryParts = $queryBuilder->buildQueryParts($sourceModelName, $cols);

        //
        $dbC = Yii::app()->db->createCommand();
        $dbC->distinct = true;
        $dbC->select('artists.name,artists.id');
        $dbC->from($queryParts[QueryBuilderAdapter::FROM_]);
        $dbC->join = $queryParts[QueryBuilderAdapter::JOIN];
        $dbC->where($this->createWhereClause($this->config->getArtistMenuFilters()));
        $dbC->order('artists.name');


        //
        $result = $dbC->queryAll();
        return $result;
    }

    private function evalOrderChar($artistName) {
        $firstChr = strtoupper($artistName{0});

        if ($firstChr >= 'A' && $firstChr <= 'Z') {
            return $firstChr;
        } else {
            return '#';
        }
    }

    /*
     * creates a array of items (artistname => link), using for a drop down menu
     */

    private function getArtistData() {

        if (!$this->config->isArtistMenuVisible()) {
            return null;
        }

        $artistData = $this->getArtists();

        if ($artistData == NULL || count($artistData) == 0) {
            return null;
        }

        $items = array(
            array('label' => 'all artists', 'url' => ParamHelper::createArtistListUrl(-1))
        );

        foreach ($artistData as $artistRow) {
            $artistId = $artistRow['id'];
            $artistName = $artistRow['name'];

            $orderChar = $this->evalOrderChar($artistName);
            if (!array_key_exists($orderChar, $items)) {
                $items[$orderChar] = array('label' => $orderChar, 'items' => array());
            }
            $items[$orderChar]['items'][] = array('label' => $artistName, 'url' => ParamHelper::createArtistListUrl($artistId));
        }

        return $items;
    }

}

?>
