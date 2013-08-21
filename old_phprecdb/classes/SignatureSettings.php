<?php
define("SIGNATURE_ENABLED", "signature_signatureEnabled");
define("ADDITIONAL_TEXT", "signature_additionalText");
define("RECORDS_COUNT", "signature_recordsCount");

define("BG_TRANSPARENT", "signature_bgTransparent");

define("BG_COLOR_RED", "signature_bgColorRed");
define("BG_COLOR_GREEN", "signature_bgColorGreen");
define("BG_COLOR_BLUE", "signature_bgColorBlue");

define("COLOR1_RED", "signature_color1Red");
define("COLOR1_GREEN", "signature_color1Green");
define("COLOR1_BLUE", "signature_color1Blue");

define("COLOR2_RED", "signature_color2Red");
define("COLOR2_GREEN", "signature_color2Green");
define("COLOR2_BLUE", "signature_color2Blue");

define("COLOR3_RED", "signature_color3Red");
define("COLOR3_GREEN", "signature_color3Green");
define("COLOR3_BLUE", "signature_color3Blue");

define("QUALITY", "signature_quality");

include_once dirname(__FILE__) . "/../constants.php";
include_once Constants::getClassFolder() . "SettingsManager.php";

class SignatureSettings {

    private $keys=array(SIGNATURE_ENABLED,
            ADDITIONAL_TEXT,
            RECORDS_COUNT,
            BG_TRANSPARENT,
            BG_COLOR_RED,
            BG_COLOR_GREEN,
            BG_COLOR_BLUE,
            COLOR1_RED,
            COLOR1_GREEN,
            COLOR1_BLUE,
            COLOR2_RED,
            COLOR2_GREEN,
            COLOR2_BLUE,
            COLOR3_RED,
            COLOR3_GREEN,
            COLOR3_BLUE,
            QUALITY);

    private $values=array();

    private $settingsManager=null;

    public function __construct() {
        $this->settingsManager=new SettingsManager();
    }

    public function load() {
        if (!$this->settingsManager->containsProperty(SIGNATURE_ENABLED)) {
            $this->setDefaults();
        }
        foreach($this->keys as $key) {
            $this->values[$key]=$this->settingsManager->getPropertyValue($key);
        }
    }

    public function save() {
        foreach($this->values as $key=>$value) {
            $this->settingsManager->setPropertyValue($key, $value);
        }
    }

    function setDefaults() {
        $this->values=array(SIGNATURE_ENABLED=>0,
                ADDITIONAL_TEXT=>'(C) phpRecDB',
                RECORDS_COUNT=>8,
                BG_TRANSPARENT=>0,
                BG_COLOR_RED=>255,
                BG_COLOR_GREEN=>255,
                BG_COLOR_BLUE=>255,
                COLOR1_RED=>0,
                COLOR1_GREEN=>0,
                COLOR1_BLUE=>0,
                COLOR2_RED=>0,
                COLOR2_GREEN=>0,
                COLOR2_BLUE=>255,
                COLOR3_RED=>100,
                COLOR3_GREEN=>100,
                COLOR3_BLUE=>100,
                QUALITY=>9);
        $this->save();
    }

    public function getKeys() {
        return $this->keys;
    }

    public function getValue($key) {
        return $this->values[$key];
    }

    public function setValue($key,$value) {
        $this->values[$key]=$value;
    }

}
?>
