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
                'value' => 'isset($data["Length"])?CHtml::encode($data["Length"]." min"):""',
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
                'value' => 'isset($data["Quality"])?CHtml::encode($data["Quality"]."/10"):""',
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
                'value' => 'CHtml::encode($data["TradeStatus"])',
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
                'header'=>'Visible',
                'type'=>'raw',
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
                'type'=>'raw',
                'name'=>'Screenshot',
                'header'=>'-',
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
                'type'=>'raw',
                'name'=>'Youtube',
                'header'=>'-',
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
                'name'=>'VisitCounter',
                'header'=>'Visits',
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
                    'name' => 'Locationh',
                    'header' => $dataProvider->sort->link('Country', 'Location', array('class' => 'sort-link')),
                    'type' => 'raw',
                    'value' => 'CHtml::encode(stripslashes((isset($data["Country"])?$data["Country"].(isset($data["City"])?", ":""):"") . (isset($data["City"])?$data["City"].(isset($data["Venue"])?" - ":""):"").$data["Venue"]." ".$data["Supplement"]))',
                )
            );
        };
        return $colsPlace;
    }

    public function getSqlBuildColNames() {
        return array(Cols::COUNTRY, Cols::CITY, Cols::VENUE, Cols::SUPPLEMENT);
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
    
    public static function getAllColNames() {
        $oClass = new ReflectionClass('Cols'); //in php 5.3 i would use static keyword
        return $oClass->getConstants();
    }

}

class ColumnStock {

    private $configCols = array();
    private $colNames = array();
    private $allSqlBuildCols = array();
    //works as hashset, data is sotred in keys
    private $selectedSqlBuildColNames = array();
    //db fields for builind the sql query 
    private $baseSqlBuildCols = array(
        "" => array("id as RecordId"),
        "concert" => array("id", "misc"),
        "concert.artist" => array("id as ArtistId"),
        "video" => "recordings_id IS NOT NULL As VideoType",
        "audio" => "recordings_id IS NOT NULL As AudioType",
    );

    const SETTINGS_DB_NAME = 'listOptions_selectedColumns';
    const SETTINGS_DEFAULT = 'CheckBox,Artist,Date,Location,Length,Quality,Type,Medium,Source,Version,Buttons,TradeStatus';

    public function __construct() {
        $colsString = Yii::app()->settingsManager->getPropertyValue(ColumnStock::SETTINGS_DB_NAME);
        $this->colNames = explode(',', $colsString);

        $this->initConfigCols();
        $this->initSqlBuildColStock();
    }
    
    public function getSelectedSqlBuildColNames() {
        return array_keys( $this->selectedSqlBuildColNames); //needed becasue data is stored in keys
    }

    private function initSqlBuildColStock() {
        $this->allSqlBuildCols[Cols::SCREENSHOT] = array("screenshots" => "video_recordings_id");
        $this->allSqlBuildCols[Cols::YOUTUBE] = array("youtubes" => "recordings_id");
        $this->allSqlBuildCols[Cols::VISITCOUNTER] = array("" => "visitcounter");
        
        $this->allSqlBuildCols[Cols::DATE] = array("concert" => "date");
        $this->allSqlBuildCols[Cols::ARTIST] = array("concert.artist" => "name");
        
        $this->allSqlBuildCols[Cols::COUNTRY] = array("concert.country" => "name");
        $this->allSqlBuildCols[Cols::CITY] = array("concert.city" => "name");
        $this->allSqlBuildCols[Cols::VENUE] = array("concert.venue" => "name");
        $this->allSqlBuildCols[Cols::TYPE] = array("rectype" => "shortname");
        $this->allSqlBuildCols[Cols::MEDIUM] = array("medium" => "shortname");
        $this->allSqlBuildCols[Cols::SOURCE] = array("source" => "shortname");
        $this->allSqlBuildCols[Cols::LENGTH] = array("" => "sumlength");
        $this->allSqlBuildCols[Cols::QUALITY] = array("" => "quality");
        $this->allSqlBuildCols[Cols::VERSION] = array("" => "sourceidentification");
        $this->allSqlBuildCols[Cols::SUPPLEMENT] = array("concert" => "supplement");
        $this->allSqlBuildCols[Cols::TRADESTATUS] = array("tradestatus" => "shortname");
        $this->allSqlBuildCols[Cols::VISIBLE] = array("" => "visible"); //TODO test
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
                    $colDefinition['htmlOptions'] = array('class' => 'col' . $cssColName);
                    //
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
