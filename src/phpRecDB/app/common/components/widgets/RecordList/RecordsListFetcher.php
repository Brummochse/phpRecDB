<?php

class RecordsListFetcher {

    const DATA_PROVIDER = 'dataProvider';
    const COLUMNS = 'columns';
    const ARTIST_ITEMS = 'artistItems';

    /** @var ListDataConfig */
    private $config;
    /** @var ColumnStock */
    private $columnStock;

    public function __construct($listDataConfig) {
        $this->config = $listDataConfig;
    }

    public function getData() {
        $data = array();

        $data[self::DATA_PROVIDER] = NULL;
        $data[self::COLUMNS] = NULL;
        if ($this->config->isRecordListVisible()) {
            $this->columnStock = new ColumnStock($this->config->isAdmin());
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
        $queryBuilder = new QueryBuilder();
        $query = $queryBuilder->buildQueryString($sourceModelName, $cols);
        //add where clause to query
        $query.=$this->createWhereClause($this->config->getRecordListFilters(), true);

        //
        $sort = new CSort;
        $sort->attributes = $this->columnStock->getSelectedSqlBuildColNames();
        $sort->defaultOrder = $this->config->getDefaultOrder($sort->attributes);

        $dataProvider = new CSqlDataProvider($query, array(
            'pagination' => false,
            'sort' => $sort,
        ));
        return $dataProvider;
    }

    ///////////////////////////////////////////////////////
    //Artistfetcher

    private function getArtists() {
        $cols = array(
            new SqlBuildCol("","id",""),
            new SqlBuildCol("artist","name","Artist"),
            new SqlBuildCol("artist","id","ArtistId"),
            new SqlBuildCol("records","id","RecordId")
        );

        //add additional cols
        $cols = array_merge($cols, $this->config->getAdditionalArtistMenuCols());

        //
        $sourceModelName = "Concert";
        $queryBuilder = new QueryBuilder();

        $queryParts = $queryBuilder->buildQueryParts($sourceModelName, $cols);

        //
        $dbC = Yii::app()->db->createCommand();
        $dbC->select('artists.name,artists.id,count(*) as recordCount');
        $dbC->from($queryParts[QueryBuilder::FROM_]);
        $dbC->join = $queryParts[QueryBuilder::JOIN];
        $dbC->where($this->createWhereClause($this->config->getArtistMenuFilters()));
        $dbC->group('artists.name,artists.id');
        $dbC->order('artists.name');
        //
        $result = $dbC->queryAll();
        return $result;
    }

    private function evalOrderChar($artistName) {
        $firstChr = strtoupper($artistName[0]);

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

        //creating labels and urls for all artists
        $artistLinkList=array();
        foreach ($artistData as $artistRow) {
            $artistId = $artistRow['id'];
            $recordCount = $artistRow['recordCount'];
            $artistName = $artistRow['name'];

            $orderChar = $this->evalOrderChar($artistName);
            if (!array_key_exists($orderChar, $artistLinkList)) {
                $artistLinkList[$orderChar]=array();
            }
            $artistLinkList[$orderChar][] = array('label' => $artistName.' ['.$recordCount.']', 'url' => ParamHelper::createArtistListUrl($artistId));
        }
        
        //chunk artist links in submenus when too much artists per character exist
        $artistMenuChunkSize=Yii::app()->params['artistMenuMaxChunkSize'];
        foreach ($artistLinkList as $char => $artists) {
            $items[$char] = array('label' => $char, 'items' => array());
            
            if (count($artists)<=$artistMenuChunkSize+1) { 
                //no submenu needed
                $items[$char]['items'] = $artists;
            } else { 
                //create several submenus for this char
                $artistCharChunks=array_chunk($artists, $artistMenuChunkSize);
                $chunkCounter=0;
                foreach ($artistCharChunks as $artistChunks) {  
                    $firstArtistCount=($chunkCounter*$artistMenuChunkSize);
                    $label='> '. $char.' ('.($firstArtistCount+1).' - '.($firstArtistCount+count($artistChunks)).')';
                    $items[$char]['items'][] = array('label'=>$label,'items'=>$artistChunks);
                    $chunkCounter++;
                }
            }
        }

        return $items;
    }
    
}

?>
