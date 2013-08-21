<?php


class RecordsListFetcher {

    const DATA_PROVIDER ='dataProvider';
    const COLUMNS ='columns';
    const ARTIST_ITEMS ='artistItems';
    
    private $config;

    public function __construct($listDataConfig) {
        $this->config = $listDataConfig;
    }

    public function getData() {
        $data=array();
        $data[self::DATA_PROVIDER] = $this->getListDataProvider();
        $data[self::COLUMNS] = $this->evalColumns($data['dataProvider']);
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
        $whereClause = "";
        foreach ($andParts as $andPart) {
            if ($andPart != NULL && strlen($andPart) > 0) {
                if (strlen($whereClause) > 0) {
                    $whereClause.=" AND ";
                }
                $whereClause.=$andPart;
            }
        }

        if (strlen($whereClause) > 0 && $generateWhere) {
            $whereClause = " WHERE " . $whereClause;
        }
        return $whereClause;
    }

    public function getListDataProvider() {

        if (!$this->config->isRecordListVisible()) {
            return NULL;
        }

        //
        $cols = array(
            "" => array("id as RecordId", "sumlength as Length", "quality as Quality", "sourceidentification as Version"),
            "concert" => array("id", "misc", "date as Date", "supplement as Supplement"),
            "concert.artist" => array("name as Artist", "id as ArtistId"),
            "concert.country" => "name as Country",
            "concert.city" => "name as City",
            "concert.venue" => "name as Venue",
            "rectype" => "shortname as Type",
            "medium" => "label as Medium",
            "source" => "shortname as Source",
            "tradestatus" => "shortname as TradeStatus",
            "video" => "recordings_id IS NOT NULL As VideoType",
            "audio" => "recordings_id IS NOT NULL As AudioType",
        );

        //add additional cols
        $cols = array_merge_recursive($cols, $this->config->getAdditionalRecordListCols());
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

    public function evalColumns($dataProvider) {
        if (!$this->config->isRecordListVisible()) {
            return NULL;
        }

        $orderBy = CPrdGridViewCore::evaluateOrderBy($dataProvider);

        //////////////////////////////
        //$colAdminCheckBox
        $colAdminCheckBox = array();
        if ($this->config->isAdmin()) {
            $colAdminCheckBox[] =
                    array(
                        'id' => Terms::CHECKBOX_ID,
                        'class' => 'CCheckBoxColumn',
                        'selectableRows' => '2', //multiple
                        'value' => '$data["RecordId"]'
            );
        }

        //////////////////////////////
        //$colsLeft
        $colsLeft = array(
            array(
                'name' => 'Artist',
                'class' => 'CPrdDataColumn',
                'htmlOptions' => array('class' => 'artist-col'),
            ),
            array(
                'name' => 'Date',
                'class' => 'CPrdDataColumn',
                'htmlOptions' => array('class' => 'date-col'),
            )
        );

        //////////////////////////////
        //$colsRight
        $colsRight = array(
            array(
                'name' => 'Length',
                'value' => 'isset($data["Length"])?CHtml::encode($data["Length"]." min"):""',
                 'htmlOptions'=>array('class' => 'length-col'),
            ),
            array(
                'name' => 'Quality',
                'value' => 'isset($data["Quality"])?CHtml::encode($data["Quality"]."/10"):""',
            ),
            'Type',
            'Medium',
            'Source',
            'Version',
        );

        //////////////////////////////
        //$colsPlace
        if ($orderBy == 'Country' || $orderBy == 'City' || $orderBy == 'Venue' || $orderBy == 'Supplement') {
            $colsPlace = array(
                'Country',
                'City',
                'Venue'
            );
        } else {
            $colsPlace = array(
                array(
                    'class' => 'CPrdDataColumn',
                    'name' => 'Location',
                    'header' => $dataProvider->sort->link('Country', 'Location', array('class' => 'sort-link')),
                    'type' => 'raw',
                    'htmlOptions' => array('class' => 'location-col'),
                    'value' => 'CHtml::encode(stripslashes((isset($data["Country"])?$data["Country"].(isset($data["City"])?", ":""):"") . (isset($data["City"])?$data["City"].(isset($data["Venue"])?" - ":""):"").$data["Venue"]." ".$data["Supplement"]))',
                )
            );
        };

        //////////////////////////////
        //$colButtons
        $colButtonOptions = array(
            'class' => 'CButtonColumn',
            'htmlOptions' => array('class' => 'buttons'),
        );
        if ($this->config->isAdmin()) {
            $colButtonOptions['template'] = '{update}{delete}';
            $colButtonOptions['updateButtonUrl'] = 'ParamHelper::createRecordUpdateUrl($data["RecordId"])';
            $colButtonOptions['deleteButtonUrl'] = 'ParamHelper::createRecordDeleteUrl($data["RecordId"])';
            $colButtonOptions['deleteConfirmation'] = Yii::t('ui', 'Are you sure to delete this record?');
        } else {
            $colButtonOptions['viewButtonUrl'] = 'ParamHelper::createRecordDetailUrl($data["RecordId"])';
            $colButtonOptions['template'] = '{view}';
        }
        $colButtons = array($colButtonOptions);

        //////////////////////////////
        //$colTradeStatus
        $colTradeStatus = array(
            array(
                'header' => '',
                'htmlOptions' => array('class' => 'trade-status'),
                'value' => 'CHtml::encode($data["TradeStatus"])',
            )
        );

        return array_merge($colAdminCheckBox, $colsLeft, $colsPlace, $colsRight, $colButtons, $colTradeStatus);
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

    public function getArtistData() {

        if (!$this->config->isArtistMenuVisible()) {
            return null;
        }

        $artistData = $this->getArtists();

        if ($artistData== NULL || count($artistData)==0) {
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
