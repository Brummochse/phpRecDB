<?php

class Columns {

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

//    function GetClassConstants($sClassName) {
//      $oClass = new ReflectionClass($sClassName);
//      return $oClass->getConstants();
//   }
}

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

    public function __construct() {
        
    }

    public function getCols($dataProvider) {
        $colsString = 'Artist,Date,Location,Length,Quality,Type,Medium,Source,Version';

        $colNames = explode(',', $colsString);
        foreach ($colNames as $colName) {
            $class = "Col" . $colName;
            
            if (class_exists($class,false)) { //predefines ConfigColumn
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
