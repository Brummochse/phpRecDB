<?php

class Settings {

    const LIST_COLLAPSED_PREFIX = "listOptions_collapsed_";
    const LIST_CACHING = "listOptions_caching";
    const LIST_COLS_FRONTEND = 'listOptions_selectedColumnsFrontend';
    const LIST_COLS_BACKEND = 'listOptions_selectedColumnsBackend';
    const SCREENSHOT_COMPRESSION = 'screenshot_compression';
    const THEME_NAME = 'theme_name';
    const USER_DEFINED1_LABEL = 'record_userDefined1Label';
    const USER_DEFINED2_LABEL = 'record_userDefined2Label';

    const WATERMARK_ENABLED = 'watermark_textEnabled';
    const WATERMARK_TEXT = 'watermark_text';
    const WATERMARK_FONTSIZE = 'watermark_fontSize';
    const WATERMARK_BORDER = 'watermark_textBorder';
    const WATERMARK_ALIGN = 'watermark_align';
    const WATERMARK_VALIGN = 'watermark_valign';
    const WATERMARK_FONTSTYLE = 'watermark_fontStyle';
    const WATERMARK_COLOR = 'watermark_color';
    const WATERMARK_THUMBNAIL = 'watermark_thumbnail';
    const WATERMARK_THUMBNAIL_RESIZE = 'watermark_resizeThumbnail';
    const LOCATION_FORMAT_PATTERN = 'location_formatPattern';

}

class SettingsManager extends CApplicationComponent {

    private $settingsTableName = "settings";
    private $cache = array();

    public function init() {
        $this->ensureSettingsTableExistence();
        parent::init();
    }

    public function setPropertyValue($property, $value) {
        $command = Yii::app()->db->createCommand();
        $command->setText(
            "REPLACE INTO " . $this->settingsTableName . " (property, value) VALUES (:property, :value)"
        );
        $command->bindParam(':property', $property, PDO::PARAM_STR);
        $command->bindParam(':value', $value, PDO::PARAM_STR);
        $command->execute();

        $this->cache[$property] = $value;
    }

    public function containsProperty($property) {
        $result = $this->getPropertyValue($property);
        return $result !== false;
    }

    public function getPropertyValue($property) {
        if (array_key_exists($property, $this->cache)) {
            return $this->cache[$property];
        }

        $command = Yii::app()->db->createCommand();
        $command->select('value')
            ->from($this->settingsTableName)
            ->where('property = :property', array(':property' => $property));
        $value = $command->queryScalar();

        $this->cache[$property] = $value;

        return $value;
    }


    private function ensureSettingsTableExistence() {
        $dbTables = Yii::app()->db->schema->tableNames;

        if (!in_array($this->settingsTableName, $dbTables)) {
            $sqlQuery = "CREATE TABLE " . $this->settingsTableName . " (" .
                "property varchar(255) NOT NULL ," .
                "value varchar(255) ," .
                "UNIQUE (property)" .
                ");";
            Yii::app()->db->createCommand($sqlQuery)->execute();
        }
    }

}

?>