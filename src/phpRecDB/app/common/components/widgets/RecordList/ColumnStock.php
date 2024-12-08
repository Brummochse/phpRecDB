<?php

abstract class ConfigColumn {

    public abstract function getColDefinitions($dataProvider, $isAdmin);

    public abstract function getSqlBuildColNames();
}

//////////////////////////////////////

class ColArtist extends ConfigColumn {

    public function getColDefinitions($dataProvider, $isAdmin) {
        return array(array(
                'name' => 'Artist',
                'class' => 'CPrdDataColumn',
        ));
    }

    public function getSqlBuildColNames() {
        return array(Cols::ARTIST);
    }
}

class ColDate extends ConfigColumn {

    public function getColDefinitions($dataProvider, $isAdmin) {
        return array(array(
                'name' => 'Date',
                'class' => 'CPrdDataColumn',
        ));
    }

    public function getSqlBuildColNames() {
        return array(Cols::DATE);
    }
}

class ColLength extends ConfigColumn {

    public function getColDefinitions($dataProvider, $isAdmin) {
        return array(array(
                'name' => 'Length',
                'value' => 'isset($data["Length"])?($data["Length"]." min"):""',
        ));
    }

    public function getSqlBuildColNames() {
        return array(Cols::LENGTH);
    }
}

class ColQuality extends ConfigColumn {

    public function getColDefinitions($dataProvider, $isAdmin) {
        return array(array(
                'name' => 'Quality',
                'value' => 'isset($data["Quality"])?($data["Quality"]."/10"):""',
        ));
    }

    public function getSqlBuildColNames() {
        return array(Cols::QUALITY);
    }
}

class ColTradeStatus extends ConfigColumn {

    public function getColDefinitions($dataProvider, $isAdmin) {
        return array(array(
                'header' => '',
                'value' => '$data["TradeStatus"]',
        ));
    }

    public function getSqlBuildColNames() {
        return array(Cols::TRADESTATUS);
    }
}

class ColCheckBox extends ConfigColumn {

    public function getColDefinitions($dataProvider, $isAdmin) {

        if ($isAdmin) {
            return array(
                array(
                    'id' => Terms::CHECKBOX_ID,
                    'class' => 'CCheckBoxColumn',
                    'selectableRows' => '2', //multiple
                    'value' => '$data["RecordId"]'
            ));
        }
        return array();
    }

    public function getSqlBuildColNames() {
        return array();
    }
}

class ColVisible extends ConfigColumn {

    public function getColDefinitions($dataProvider, $isAdmin) {

        if ($isAdmin) {
            return array(array(
                    'name' => 'Visible',
                    'header' => 'Visible',
                    'type' => 'raw',
                    'value' => 'CHtml::image(Yii::app()->params["wwwUrl"]."/images/".(($data["Visible"])?"visible.png":"hidden.png") )',
            ));
        }
        return array();
    }

    public function getSqlBuildColNames() {
        return array(Cols::VISIBLE);
    }
}

class ColScreenshot extends ConfigColumn {

    public function getColDefinitions($dataProvider, $isAdmin) {
        return array(array(
                'type' => 'raw',
                'name' => 'Screenshot',
                'header' => '-',
                'value' => 'isset($data["Screenshot"])?CHtml::image(Yii::app()->params["wwwUrl"]."/images/screenshot.png"):""',
        ));
    }

    public function getSqlBuildColNames() {
        return array(Cols::SCREENSHOT);
    }
}

class ColYoutube extends ConfigColumn {

    public function getColDefinitions($dataProvider, $isAdmin) {
        return array(array(
                'type' => 'raw',
                'name' => 'Youtube',
                'header' => '-',
                'value' => 'isset($data["Youtube"])?CHtml::image(Yii::app()->params["wwwUrl"]."/images/youtube.gif"):""',
        ));
    }

    public function getSqlBuildColNames() {
        return array(Cols::YOUTUBE);
    }
}

class ColVisitCounter extends ConfigColumn {

    public function getColDefinitions($dataProvider, $isAdmin) {
        return array(array(
                'name' => 'VisitCounter',
                'header' => 'Visits',
                'value' => 'isset($data["VisitCounter"])?$data["VisitCounter"]:0',
        ));
    }

    public function getSqlBuildColNames() {
        return array(Cols::VISITCOUNTER);
    }
}

class ColButtons extends ConfigColumn {

    public function getColDefinitions($dataProvider, $isAdmin) {
        $colButtonOptions = array(
            'class' => 'CButtonColumn',
        );
        if ($isAdmin) {
            $colButtonOptions['template'] = '{update}{delete}';
            $colButtonOptions['updateButtonUrl'] = 'ParamHelper::createRecordUpdateUrl($data["RecordId"])';
            $colButtonOptions['deleteButtonUrl'] = 'ParamHelper::createRecordDeleteUrl($data["RecordId"])';
            $colButtonOptions['deleteConfirmation'] = Yii::t('ui', 'Are you sure to delete this record?');
        } else {
            $colButtonOptions['viewButtonUrl'] = 'ParamHelper::createRecordDetailUrl($data["RecordId"])';
            $colButtonOptions['template'] = '{view}';
        }
        return array($colButtonOptions);
    }

    public function getSqlBuildColNames() {
        return array();
    }
}

class ColLocation extends ConfigColumn {

    public function getColDefinitions($dataProvider, $isAdmin) {
        $orderBy = CPrdGridViewCore::evaluateOrderBy($dataProvider);

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
                    'value' => 'CHtml::encode(stripslashes((isset($data["Country"])?$data["Country"].(isset($data["City"])?", ":""):"") . (isset($data["City"])?$data["City"].(isset($data["Venue"])?" - ":""):"").$data["Venue"]." ".$data["Supplement"]))'
                )
            );
        };
        return $colsPlace;
    }

    public function getSqlBuildColNames() {
        return array(Cols::COUNTRY, Cols::CITY, Cols::VENUE, Cols::SUPPLEMENT);
    }
}

class ColUserDefined1 extends ConfigColumn {

    public function getColDefinitions($dataProvider, $isAdmin) {
        return array(array(
                'header' => Yii::app()->settingsManager->getPropertyValue(Settings::USER_DEFINED1_LABEL),
                'name'=>Cols::USERDEFINED1
        ));
    }

    public function getSqlBuildColNames() {
        return array(Cols::USERDEFINED1);
    }
}

class ColUserDefined2 extends ConfigColumn {

    public function getColDefinitions($dataProvider, $isAdmin) {
        return array(array(
                'header' => Yii::app()->settingsManager->getPropertyValue(Settings::USER_DEFINED2_LABEL),
                'name'=>Cols::USERDEFINED2
        ));
    }

    public function getSqlBuildColNames() {
        return array(Cols::USERDEFINED2);
    }
}

class Cols {

    const ARTIST = 'Artist';
    const DATE = 'Date';
    const LENGTH = 'Length';
    const QUALITY = 'Quality';
    const TYPE = 'Type';
    const MEDIUM = 'Medium';
    const SOURCE = 'Source';
    const VERSION = 'Version';
    const COUNTRY = 'Country';
    const CITY = 'City';
    const VENUE = 'Venue';
    const LOCATION = 'Location';
    const SUPPLEMENT = 'Supplement';
    const TRADESTATUS = 'TradeStatus';
    const BUTTONS = 'Buttons';
    const CHECKBOX = 'CheckBox';
    const VISIBLE = 'Visible';
    const SCREENSHOT = 'Screenshot';
    const YOUTUBE = 'Youtube';
    const VISITCOUNTER = 'VisitCounter';
    const VIDEOFORMAT = 'VideoFormat';
    const ASPECTRATIO = 'AspectRatio';
    const USERDEFINED1 = 'UserDefined1';
    const USERDEFINED2 = 'UserDefined2';

    public static function getAllColNames() {
        $oClass = new ReflectionClass('Cols'); //in php 5.3 i would use static keyword
        return $oClass->getConstants();
    }

    //cols only available in admin panel
    public static $BACKEND_ONLY_COLS = array(Cols::CHECKBOX, Cols::VISIBLE, Cols::VISITCOUNTER);
    //cols must exist in query, not allowed to remove
    public static $REQUIRED_COLS = array(Cols::ARTIST, Cols::DATE);
}

class ColumnStock {

    private $configCols = array();
    private $colNames = array();
    private $allSqlBuildCols = array();
    //works as hashset, data is sorted in keys
    private $selectedSqlBuildColNames = array();
    //db fields for builind the sql query 
    private $baseSqlBuildCols = array();

    const SETTINGS_DEFAULT_FRONTEND = 'Artist,Date,Location,Length,Quality,Type,Medium,Source,Version,Buttons,TradeStatus';
    const SETTINGS_DEFAULT_BACKEND = 'CheckBox,Artist,Date,Location,Length,Quality,Type,Medium,Source,Version,Buttons,TradeStatus';

    public function __construct($isAdmin = false) {
        $this->initBaseSqlBuildCols();

        if ($isAdmin) { //means backend col settings get loaded
            $dbColSettingsName = Settings::LIST_COLS_BACKEND;
        } else { //frontend cols
            $dbColSettingsName = Settings::LIST_COLS_FRONTEND;
        }

        $colsString = Yii::app()->settingsManager->getPropertyValue($dbColSettingsName);
        $this->colNames = explode(',', $colsString);

        $this->initConfigCols();
        $this->initSqlBuildColStock();
    }

    public function initBaseSqlBuildCols()
    {
        $this->baseSqlBuildCols[] = new SqlBuildCol("", "id", "RecordId");
        $this->baseSqlBuildCols[] = new SqlBuildCol("concert", "id", "");
        $this->baseSqlBuildCols[] = new SqlBuildCol("concert", "misc", "");
        $this->baseSqlBuildCols[] = new SqlBuildCol("concert.artist", "id", "ArtistId");
        $this->baseSqlBuildCols[] = new SqlBuildCol("video", "recordings_id IS NOT NULL", "VideoType");
        $this->baseSqlBuildCols[] = new SqlBuildCol("audio", "recordings_id IS NOT NULL", "AudioType");

//        "" => array("id as RecordId"),
//        "concert" => array("id", "misc"),
//        "concert.artist" => array("id as ArtistId"),
//        "video" => "recordings_id IS NOT NULL As VideoType",
//        "audio" => "recordings_id IS NOT NULL As AudioType",

    }

    public function getSelectedSqlBuildColNames() {
        return array_keys($this->selectedSqlBuildColNames); //needed becasue data is stored in keys
    }



    private function initSqlBuildColStock() {
        $this->allSqlBuildCols[] = new SqlBuildCol("screenshots" , "video_recordings_id",Cols::SCREENSHOT);
        $this->allSqlBuildCols[] = new SqlBuildCol("youtubes", "recordings_id",Cols::YOUTUBE);
        $this->allSqlBuildCols[] = new SqlBuildCol("recordvisit", "visitors",Cols::VISITCOUNTER);
        $this->allSqlBuildCols[] = new SqlBuildCol("concert.artist", "name",Cols::ARTIST);
        $this->allSqlBuildCols[] = new SqlBuildCol("concert.country", "name",Cols::COUNTRY);
        $this->allSqlBuildCols[] = new SqlBuildCol("concert.city", "name",Cols::CITY);
        $this->allSqlBuildCols[] = new SqlBuildCol("concert.venue", "name",Cols::VENUE);
        $this->allSqlBuildCols[] = new SqlBuildCol("rectype", "shortname",Cols::TYPE);
        $this->allSqlBuildCols[] = new SqlBuildCol("medium", "shortname",Cols::MEDIUM);
        $this->allSqlBuildCols[] = new SqlBuildCol("source", "shortname",Cols::SOURCE);
        $this->allSqlBuildCols[] = new SqlBuildCol("", "sumlength",Cols::LENGTH);
        $this->allSqlBuildCols[] = new SqlBuildCol("", "quality",Cols::QUALITY);
        $this->allSqlBuildCols[] = new SqlBuildCol("", "userdefined1",Cols::USERDEFINED1);
        $this->allSqlBuildCols[] = new SqlBuildCol("", "userdefined2",Cols::USERDEFINED2);
        $this->allSqlBuildCols[] = new SqlBuildCol("", "sourceidentification",Cols::VERSION);
        $this->allSqlBuildCols[] = new SqlBuildCol("concert", "supplement",Cols::SUPPLEMENT);
        $this->allSqlBuildCols[] = new SqlBuildCol("tradestatus", "shortname",Cols::TRADESTATUS);
        $this->allSqlBuildCols[] = new SqlBuildCol("", "visible",Cols::VISIBLE);
        $this->allSqlBuildCols[] = new SqlBuildCol("video.videoformat", "label",Cols::VIDEOFORMAT);
        $this->allSqlBuildCols[] = new SqlBuildCol("video.aspectratio", "label",Cols::ASPECTRATIO);
        $this->allSqlBuildCols[] = new class extends SqlBuildCol {
            public function __construct()
            {
                parent::__construct("concert", "date", Cols::DATE);
            }

            public function postProcess($sqlColIdentifier)
            {
                return "DATE_FORMAT(".$sqlColIdentifier.", '%Y-%m-%d')";
            }
        };
    }

    /**
     * - loads all Col****-classes, for future use
     * - evaluate which sqlBuildCol-Definitions are required (-> selectedSqlBuildColNames )
     */
    private function initConfigCols() {
        foreach ($this->colNames as $colName) {
            $class = "Col" . $colName;

            if (class_exists($class, false)) { //predefines ConfigColumn
                $configCol = new $class();
                $this->configCols[$colName] = $configCol;
                foreach ($configCol->getSqlBuildColNames() as $sqlBuildColName) {
                    $this->selectedSqlBuildColNames[$sqlBuildColName] = NULL;
                }
            } else {
                $this->selectedSqlBuildColNames[$colName] = NULL;
            }
        }
    }

    public function getColDefinitions($dataProvider, $isAdmin) {
        $colDefinitions = array();

        foreach ($this->colNames as $colName) {

            if (key_exists($colName, $this->configCols)) { //predefines ConfigColumn exist
                $configCol = $this->configCols[$colName];
                foreach ($configCol->getColDefinitions($dataProvider, $isAdmin) as $colDefinition) {

                    //add css class
                    if (!is_array($colDefinition)) {
                        $colDefinition = array(
                            'name' => $colDefinition,
                        );
                    }
                    $cssColName = isset($colDefinition['name']) ? $colDefinition['name'] : $colName;
                    $colDefinition['htmlOptions'] = array('class' => 'c' . $cssColName);
                    //
                    $colDefinitions[] = $colDefinition;
                }
            } else { //add colname directly to array, no special col configuration needed
                $colDefinitions[] = $colName;
            }
        }
        return $colDefinitions;
    }

    public function getQueryBuilderSettings(array $additionalCols) {

        foreach ($this->selectedSqlBuildColNames as $sqlBuildColName => $notNeededValue) {

            $sqlCol=current(array_filter($this->allSqlBuildCols, function($e) use ($sqlBuildColName) {return $e->colLabel == $sqlBuildColName;}));

            if ($sqlCol==null) {
                continue; //no special sql needed for this col
            }
            $this->baseSqlBuildCols[]=$sqlCol;
        }

        foreach ($additionalCols as $sqlCol) {
            $this->baseSqlBuildCols[]=$sqlCol;
        }

        return $this->baseSqlBuildCols;
    }





}

?>
