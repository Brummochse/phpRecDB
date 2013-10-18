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
                'htmlOptions' => array('class' => 'artist-col'),
        ));
    }

    public function getSqlBuildColNames() {
        return array(ColumnStock::ARTIST);
    }

}

class ColDate extends ConfigColumn {

    public function getColDefinitions($dataProvider, $isAdmin) {
        return array(array(
                'name' => 'Date',
                'class' => 'CPrdDataColumn',
                'htmlOptions' => array('class' => 'date-col'),
        ));
    }

    public function getSqlBuildColNames() {
        return array(ColumnStock::DATE);
    }

}

class ColLength extends ConfigColumn {

    public function getColDefinitions($dataProvider, $isAdmin) {
        return array(array(
                'name' => 'Length',
                'value' => 'isset($data["Length"])?CHtml::encode($data["Length"]." min"):""',
                'htmlOptions' => array('class' => 'length-col'),
        ));
    }

    public function getSqlBuildColNames() {
        return array(ColumnStock::LENGTH);
    }

}

class ColQuality extends ConfigColumn {

    public function getColDefinitions($dataProvider, $isAdmin) {
        return array(array(
                'name' => 'Quality',
                'value' => 'isset($data["Quality"])?CHtml::encode($data["Quality"]."/10"):""',
        ));
    }

    public function getSqlBuildColNames() {
        return array(ColumnStock::QUALITY);
    }

}

class ColTradeStatus extends ConfigColumn {

    public function getColDefinitions($dataProvider, $isAdmin) {
        return array(array(
                'header' => '',
                'htmlOptions' => array('class' => 'trade-status'),
                'value' => 'CHtml::encode($data["TradeStatus"])',
        ));
    }

    public function getSqlBuildColNames() {
        return array(ColumnStock::TRADESTATUS);
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
            return array(ColumnStock::VISIBLE);
        }
        return array();
    }

    public function getSqlBuildColNames() {
        return array(ColumnStock::VISIBLE);
    }

}

class ColButtons extends ConfigColumn {

    public function getColDefinitions($dataProvider, $isAdmin) {
        $colButtonOptions = array(
            'class' => 'CButtonColumn',
            'htmlOptions' => array('class' => 'buttons'),
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
                    'htmlOptions' => array('class' => 'location-col'),
                    'value' => 'CHtml::encode(stripslashes((isset($data["Country"])?$data["Country"].(isset($data["City"])?", ":""):"") . (isset($data["City"])?$data["City"].(isset($data["Venue"])?" - ":""):"").$data["Venue"]." ".$data["Supplement"]))',
                )
            );
        };
        return $colsPlace;
    }

    public function getSqlBuildColNames() {
        return array(ColumnStock::COUNTRY, ColumnStock::CITY, ColumnStock::VENUE, ColumnStock::SUPPLEMENT);
    }

}

class ColumnStock {

    private $configCols = array();
    private $colNames = array();
    private $allSqlBuildCols = array();
    private $selectedSqlBuildColNames = array();
    //db fields for builind the sql query 
    private $baseSqlBuildCols = array(
        "" => array("id as RecordId"),
        "concert" => array("id", "misc"),
        "concert.artist" => array("id as ArtistId", "name as Artist"),
        "video" => "recordings_id IS NOT NULL As VideoType",
        "audio" => "recordings_id IS NOT NULL As AudioType",
    );

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
    const TRADESTATUS = 'TradeStatus';
    const BUTTONS = 'Buttons';
    const CHECKBOX = 'CheckBox';
    const VISIBLE = 'Visible';

    public function __construct() {
        $colsString = Yii::app()->settingsManager->getPropertyValue(ColumnStock::SETTINGS_DB_NAME);
        $this->colNames = explode(',', $colsString);

        $this->initConfigCols();
        $this->initSqlBuildColStock();
    }

    private function initSqlBuildColStock() {
        $this->allSqlBuildCols[self::COUNTRY] = array("concert.country" => "name");
        $this->allSqlBuildCols[self::CITY] = array("concert.city" => "name");
        $this->allSqlBuildCols[self::VENUE] = array("concert.venue" => "name");
        $this->allSqlBuildCols[self::TYPE] = array("rectype" => "shortname");
        $this->allSqlBuildCols[self::MEDIUM] = array("medium" => "shortname");
        $this->allSqlBuildCols[self::SOURCE] = array("source" => "shortname");
        $this->allSqlBuildCols[self::LENGTH] = array("" => "sumlength");
        $this->allSqlBuildCols[self::QUALITY] = array("" => "quality");
        $this->allSqlBuildCols[self::VERSION] = array("" => "sourceidentification");
        $this->allSqlBuildCols[self::DATE] = array("concert" => "date");
        $this->allSqlBuildCols[self::SUPPLEMENT] = array("concert" => "supplement");
        $this->allSqlBuildCols[self::TRADESTATUS] = array("tradestatus" => "shortname");
        $this->allSqlBuildCols[self::VISIBLE] = array("" => "visible"); //TODO test
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

    public static function getAllColNames() {
        $oClass = new ReflectionClass('ColumnStock'); //in php 5.3 i would use static keyword
        $constants = $oClass->getConstants();

        //remove constants which aren't col names
        unset($constants[array_search(self::SETTINGS_DB_NAME, $constants)]);
        unset($constants[array_search(self::SETTINGS_DEFAULT, $constants)]);

        return $constants;
    }

    public function getColDefinitions($dataProvider, $isAdmin) {
        $colDefinitions = array();

        foreach ($this->colNames as $colName) {

            if (key_exists($colName, $this->configCols)) { //predefines ConfigColumn exist
                $configCol = $this->configCols[$colName];
                foreach ($configCol->getColDefinitions($dataProvider, $isAdmin) as $colDefinition) {
                    $colDefinitions[] = $colDefinition;
                }
            } else { //add colname directly to array, no special col configuration needed
                $colDefinitions[] = $colName;
            }
        }
        return $colDefinitions;
    }

    public function getQueryBuilderSettings($additionalCols) {

        foreach ($this->selectedSqlBuildColNames as $sqlBuildColName => $notNeededValue) {
            if (!key_exists($sqlBuildColName, $this->allSqlBuildCols)) {
                continue; //no special sql needed for this col
            }

            $sqlBuildColDefinition = $this->allSqlBuildCols[$sqlBuildColName];
            $path = key($sqlBuildColDefinition);
            $field = $sqlBuildColDefinition[$path] . ' as ' . $sqlBuildColName;
            $this->addSqlBuildColDefinition($path, $field);
        }

        foreach ($additionalCols as $path => $field) {
            $this->addSqlBuildColDefinition($path, $field);
        }

        return $this->baseSqlBuildCols;
    }

    private function addSqlBuildColDefinition($path, $field) {
        if (!key_exists($path, $this->baseSqlBuildCols)) {
            $this->baseSqlBuildCols[$path] = array();
        }
        $this->baseSqlBuildCols[$path][] = $field;
    }

}

?>
