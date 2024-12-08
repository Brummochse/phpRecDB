<?php


class SqlBuildCol {
    public $colName;
    public $path;
    public $colLabel;

    public function __construct($path, $colName, $colLabel)
    {
        $this->colName = $colName;
        $this->path = $path;
        $this->colLabel = $colLabel;
    }

    //can be overridden if specific col-specific behaviour is required
    public function postProcess($sqlColIdentifier) {
        return $sqlColIdentifier;
    }

}