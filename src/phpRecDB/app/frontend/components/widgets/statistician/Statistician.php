<?php

class Statistician extends CWidget {

    private $concertAndRecordCriteria = NULL;
    protected $recTypeSelection;
    protected $includeMisc;
    protected $recTypesList = array(
        '0' => 'All Records',
        '1' => 'Only Videos',
        '2' => 'Only Audios',
    );

    const STATISTICS_DIAG_ID = "statDiag";
    const ARTIST_DIAG_ID = 1;
    const COUNTRY_DIAG_ID = 2;
    const CITY_DIAG_ID = 3;
    const VENUE_DIAG_ID = 4;

    private function getConcertAndRecordCriteria() {
        if ($this->concertAndRecordCriteria == NULL) {

            $criteria = new CDbCriteria;
            $criteria->with = array(
                'concerts',
                'concerts.records',
            );

            //if not all records => bind table for video or audio
            if ($this->recTypeSelection == 1) { //only Videos
                $criteria->with['concerts.records.video'] = array('joinType' => 'INNER JOIN');
            }
            if ($this->recTypeSelection == 2) { //only Audios
                $criteria->with['concerts.records.audio'] = array('joinType' => 'INNER JOIN');
            }

            //include only visible records
            $criteria->condition = "visible = true";

            //decide if misc records get included or not
            if ($this->includeMisc == 0) {
                $criteria->condition = $criteria->condition . " AND misc != true";
            }

            $criteria->together = true;

            $this->concertAndRecordCriteria = $criteria;
        }
        return $this->concertAndRecordCriteria;
    }

    private function getCommonArtistsDataProvider() {
        $criteria = $this->getConcertAndRecordCriteria();

        Artist::model()->setDbCriteria($criteria);
        $artistResult = Artist::model()->findAll();

        $artistData = array();
        $id = 1;
        foreach ($artistResult as $ac) {
            $length = 0;
            $recordsCount = 0;

            foreach ($ac->concerts as $concert) {
                $recordsCount += count($concert->records);

                foreach ($concert->records as $record) {
                    $length += $record->sumlength;
                }
            }

            $artistData[] = array(
                "id" => $id++,
                "name" => $ac->name,
                "concerts" => count($ac->concerts),
                "records" => $recordsCount,
                "length" => $length);
        }

        return $this->createArrayDataProvider($artistData, array('name', 'concerts', 'records', 'length'), 'length');
    }

    private function createArrayDataProvider($data, $attributes, $sort, $pageSize = 10) {
        $arrayDataProvider = new CArrayDataProvider($data, array(
                    'id' => 'id',
                    'sort' => array(
                        'attributes' => $attributes,
                        'defaultOrder' => $sort . ' DESC',
                    ),
                    'pagination' => array(
                        'pageSize' => $pageSize,
                    ),
                ));
        return $arrayDataProvider;
    }

    private function getCommonCountriesDataProvider() {
        $criteria = $this->getConcertAndRecordCriteria();

        Country::model()->setDbCriteria($criteria);
        $cd = Country::model()->findAll();

        $countryData = array();
        $id = 1;
        foreach ($cd as $ac) {
            $recordsCount = 0;

            foreach ($ac->concerts as $concert) {
                $recordsCount += count($concert->records);
            }

            $countryData[] = array(
                "id" => $id++,
                "name" => $ac->name,
                "concerts" => count($ac->concerts),
                "records" => $recordsCount);
        }

        return $this->createArrayDataProvider($countryData, array('name', 'concerts', 'records'), 'concerts');
    }

    private function getCommonCitiesDataProvider() {
        $criteria = $this->getConcertAndRecordCriteria();

        City::model()->setDbCriteria($criteria);
        $cd = City::model()->findAll();


        $cityData = array();
        $id = 1;
        foreach ($cd as $ac) {
            $recordsCount = 0;

            foreach ($ac->concerts as $concert) {
                $recordsCount += count($concert->records);
            }

            $name = $ac->name;
            if ($ac->country != null) {
                $name = $name . " (" . $ac->country->name . ")";
            }

            $cityData[] = array(
                "id" => $id++,
                "name" => $name,
                "concerts" => count($ac->concerts),
                "records" => $recordsCount);
        }

        return $this->createArrayDataProvider($cityData, array('name', 'concerts', 'records'), 'concerts');
    }

    private function getCommonVenuesDataProvider() {
        $criteria = $this->getConcertAndRecordCriteria();

        Venue::model()->setDbCriteria($criteria);
        $vd = Venue::model()->findAll();

        $venueData = array();
        $id = 1;

        foreach ($vd as $ac) {
            $recordsCount = 0;

            foreach ($ac->concerts as $concert) {
                $recordsCount += count($concert->records);
            }

            $venueData[] = array(
                "id" => $id++,
                "name" => (string)$ac,
                "concerts" => count($ac->concerts),
                "records" => $recordsCount);
        }
        return $this->createArrayDataProvider($venueData, array('name', 'concerts', 'records'), 'concerts');
    }

    private function getScreenshotCount() {
        $visibleWhere = 'visible = true';
        $miscWhere = 'misc != true';

        $query = Yii::app()->db->createCommand()
                ->select('count(s.id)')
                ->from('screenshot s')
                ->leftJoin('recordings r', 's.video_recordings_id=r.id')
                ->leftJoin('concerts c', 'r.concerts_id=c.id')
                ->where($this->includeMisc == 0 ? $visibleWhere . ' AND ' . $miscWhere : $visibleWhere);

        return $query->queryScalar();
    }

    private function getCommonStats() {
        $lengthCount = 0;
        $recordsCount = 0;
        $concertsCount = 0;

        $lengthAverageShowsCount = 0;

        $criteria = $this->getConcertAndRecordCriteria();

        Artist::model()->setDbCriteria($criteria);
        $artistResult = Artist::model()->findAll();

        foreach ($artistResult as $ac) {
            $concertsCount += count($ac->concerts);

            foreach ($ac->concerts as $concert) {
                $recordsCount += count($concert->records);

                foreach ($concert->records as $record) {
                    $lengthCount += $record->sumlength;

                    if ($record->sumlength != NULL && $record->sumlength) {
                        //only calculate avarage length for shows which have a length > 0
                        $lengthAverageShowsCount++;
                    }
                }
            }
        }

        $commonStats = array();
        $commonStats['Show_Count'] = $concertsCount;
        $commonStats['Record_Count'] = $recordsCount;
        $commonStats['Overall_Length'] = $lengthCount . " min (" . number_format(($lengthCount / 60), 2) . " hour)";

        if ($lengthAverageShowsCount > 0) {
            $commonStats['Avarage_Length'] = number_format($lengthCount / $lengthAverageShowsCount, 2) . " min";
        }

        if ($this->recTypeSelection == 1) { //only Videos
            $commonStats['Screenshots'] = $this->getScreenshotCount();
        }

        return $commonStats;
    }

    private function evaluateRecordFilterParameters($_postOrGetArray) {

        //evaluate record type selection
        if (isset($_postOrGetArray['recType']) && isset($this->recTypesList[$_postOrGetArray['recType']])) {
            $this->recTypeSelection = $_postOrGetArray['recType'];
        } else {

            //default selection: all records
            $this->recTypeSelection = 0;

            if (Audio::model()->count() == 0 && Video::model()->count() > 0) {
                $this->recTypeSelection = 1; //video
            }
            if (Video::model()->count() == 0 && Audio::model()->count() > 0) {
                $this->recTypeSelection = 2; //audio
            }
        }

        //evaluate misc include status
        if (isset($_postOrGetArray['includeMisc']) && $_postOrGetArray['includeMisc'] == 1) {
            $this->includeMisc = true;
        } else {

            // default: do NOT use misc records
            $this->includeMisc = 0;
        }
    }

    public function run() {


        $statDiag = ParamHelper::decodeIntGetParam(self::STATISTICS_DIAG_ID);
        if ($statDiag == self::ARTIST_DIAG_ID) {
            $this->actionGetArtistsDialog();
        } else if ($statDiag == self::COUNTRY_DIAG_ID) {
            $this->actionGetCountriesDialog();
        } else if ($statDiag == self::CITY_DIAG_ID) {
            $this->actionGetCitiesDialog();
        } else if ($statDiag == self::VENUE_DIAG_ID) {
            $this->actionGetVenuesDialog();
        } else {

            $this->evaluateRecordFilterParameters($_POST);

            $ajaxUrlParameters = array_merge(array_filter($_GET, 'strlen'), array('includeMisc' => $this->includeMisc, 'recType' => $this->recTypeSelection));

            //artist stats
            Artist::model()->setDbCriteria($this->getConcertAndRecordCriteria());
            $artistStats['artistCount'] = Artist::model()->count();
            $route=Yii::app()->controller->getId().'/'.Yii::app()->controller->getAction()->getId();
            $artistStats['commonArtistsURL'] = Yii::app()->createUrl($route, array_merge($ajaxUrlParameters,array(self::STATISTICS_DIAG_ID => self::ARTIST_DIAG_ID)));

            //location stats
            Country::model()->setDbCriteria($this->getConcertAndRecordCriteria());
            $locationStats['countriesCount'] = Country::model()->count();
            City::model()->setDbCriteria($this->getConcertAndRecordCriteria());
            $locationStats['citiesCount'] = City::model()->count();
            Venue::model()->setDbCriteria($this->getConcertAndRecordCriteria());
            $locationStats['venuesCount'] = Venue::model()->count();

            $locationStats['commonCountriesURL'] =Yii::app()->createUrl($route, array_merge($ajaxUrlParameters,array(self::STATISTICS_DIAG_ID => self::COUNTRY_DIAG_ID)));
            $locationStats['commonCitiesURL'] =Yii::app()->createUrl($route, array_merge($ajaxUrlParameters,array(self::STATISTICS_DIAG_ID => self::CITY_DIAG_ID)));
            $locationStats['commonVenuesURL'] = Yii::app()->createUrl($route, array_merge($ajaxUrlParameters,array(self::STATISTICS_DIAG_ID => self::VENUE_DIAG_ID)));


            $variousRecordStats = $this->getCommonStats();

            $this->render('statistics', array(
                'variousRecordStats' => $variousRecordStats,
                'artistStats' => $artistStats,
                'locationStats' => $locationStats,
            ));
        }
    }

    public function getRecType() {
        return $this->getPageState('recType');
    }

    public function setRecType($value) {
        $this->setPageState('recType', $value);
    }

    public function actionGetCountriesDialog() {
        $this->evaluateRecordFilterParameters($_GET);
        $countriesData = $this->getCommonCountriesDataProvider();

        $this->render('_countries', array('countriesData' => $countriesData), false, true);
    }

    public function actionGetArtistsDialog() {
        $this->evaluateRecordFilterParameters($_GET);
        $artistsData = $this->getCommonArtistsDataProvider();

        $this->render('_artists', array('artistsData' => $artistsData,), false, true);
    }

    public function actionGetCitiesDialog() {
        $this->evaluateRecordFilterParameters($_GET);
        $citiesData = $this->getCommonCitiesDataProvider();

        $this->render('_cities', array('citiesData' => $citiesData,), false, true);
    }

    public function actionGetVenuesDialog() {
        $this->evaluateRecordFilterParameters($_GET);
        $venuesData = $this->getCommonVenuesDataProvider();

        $this->render('_venues', array('venuesData' => $venuesData,), false, true);
    }

}

?>
