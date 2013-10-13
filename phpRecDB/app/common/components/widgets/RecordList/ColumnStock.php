<?php

abstract class ConfigColumn {

    public abstract function getColDefinitions($dataProvider);
}

//////////////////////////////////////

class ColArtist extends ConfigColumn {

    public function getColDefinitions($dataProvider) {
        return array(array(
                'name' => 'Artist',
                'class' => 'CPrdDataColumn',
                'htmlOptions' => array('class' => 'artist-col'),
        ));
    }

}

class ColDate extends ConfigColumn {

    public function getColDefinitions($dataProvider) {
        return array(array(
                'name' => 'Date',
                'class' => 'CPrdDataColumn',
                'htmlOptions' => array('class' => 'date-col'),
        ));
    }

}

class ColLength extends ConfigColumn {

    public function getColDefinitions($dataProvider) {
        return array(array(
                'name' => 'Length',
                'value' => 'isset($data["Length"])?CHtml::encode($data["Length"]." min"):""',
                'htmlOptions' => array('class' => 'length-col'),
        ));
    }

}

class ColQuality extends ConfigColumn {

    public function getColDefinitions($dataProvider) {
        return array(array(
                'name' => 'Quality',
                'value' => 'isset($data["Quality"])?CHtml::encode($data["Quality"]."/10"):""',
        ));
    }

}

//////////////////////////////////////

class ColLocation extends ConfigColumn {

    public function getColDefinitions($dataProvider) {
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
                    'htmlOptions' => array('class' => 'location-col'),
                    'value' => 'CHtml::encode(stripslashes((isset($data["Country"])?$data["Country"].(isset($data["City"])?", ":""):"") . (isset($data["City"])?$data["City"].(isset($data["Venue"])?" - ":""):"").$data["Venue"]." ".$data["Supplement"]))',
                )
            );
        };
        return $colsPlace;
    }

}

class ColumnStock {

    private $cols = array();

    const SETTINGS_DB_NAME = 'listOptions_selectedColumns';
    const SETTINGS_DEFAULT = 'Artist,Date,Location,Length,Quality,Type,Medium,Source,Version';
    
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

    public function __construct() {
        $sqlBuildCols = array();
        $sqlBuildCols[self::COUNTRY] = array("concert.country" => "name as Country");
        $sqlBuildCols[self::CITY] = array("concert.city" => "name as City");
        $sqlBuildCols[self::VENUE] = array("concert.venue" => "name as Venue");
        $sqlBuildCols[self::TYPE] = array("rectype" => "shortname as Type");
        $sqlBuildCols[self::MEDIUM] = array("medium" => "shortname as Medium");
        $sqlBuildCols[self::SOURCE] = array("source" => "shortname as Source");
        $sqlBuildCols[self::LENGTH] = array("" => "sumlength as Length");
        $sqlBuildCols[self::QUALITY] = array("" => "quality as Quality");
        $sqlBuildCols[self::VERSION] = array("" => "sourceidentification as Version");
        $sqlBuildCols[self::DATE] = array("concert" => "date as Date");
        $sqlBuildCols[self::SUPPLEMENT] = array("concert" => "supplement as Supplement");

        //db fields for builind the sql query 
        $baseSqlBuildCols = array(
            "" => array("id as RecordId"),
            "concert" => array("id", "misc"),
            "concert.artist" => array("id as ArtistId","name as Artist"),
            "tradestatus" => "shortname as TradeStatus",
            "video" => "recordings_id IS NOT NULL As VideoType",
            "audio" => "recordings_id IS NOT NULL As AudioType",
        );
    }

    public static function getAllColNames() {
        $oClass = new ReflectionClass('ColumnStock'); //in php 5.3 i would use static keyword
        $constants = $oClass->getConstants();

        //remove constants which aren't col names
        unset($constants[array_search(self::SETTINGS_DB_NAME, $constants)]);
        unset($constants[array_search(self::SETTINGS_DEFAULT, $constants)]);

        return $constants;
    }

    public function getCols($dataProvider) {
        $colsString = Yii::app()->settingsManager->getPropertyValue(ColumnStock::SETTINGS_DB_NAME);

        $colNames = explode(',', $colsString);
        foreach ($colNames as $colName) {
            $class = "Col" . $colName;

            if (class_exists($class, false)) { //predefines ConfigColumn
                $configCol = new $class();
                $colDefinitions = $configCol->getColDefinitions($dataProvider);
                foreach ($colDefinitions as $colDefinition) {
                    $this->cols[] = $colDefinition;
                }
            } else { //add colname directly to array, no special col configuration needed
                $this->cols[] = $colName;
            }
        }

        return $this->cols;
    }

}

?>
