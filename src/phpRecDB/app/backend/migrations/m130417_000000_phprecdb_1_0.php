<?php

class m130417_000000_phprecdb_1_0 extends CDbMigration {

    const DB_VERSION = 1.0;

    public function safeUp() {

        //create new user table
        $this->createTable('user', array(
            "id" => "pk",
            "username" => "string NOT NULL",
            "password" => "string NOT NULL",
            "salt" => "string NOT NULL",
            "role" => "string NOT NULL",
        ));

        //add default user admin/secret
        $this->insert('user', array(
            'username' => 'admin',
            'password' => '301c8f149458935864e0571c4a924d2d',
            'salt' => '51326697797012.15232076',
            'role' => 'admin'
        ));

        //delte old myuser table
        $this->dropTable('myuser');

        //extend limited cols 
        $this->execute("ALTER TABLE concerts MODIFY supplement VARCHAR(255)");
        $this->execute("ALTER TABLE videoformat MODIFY label VARCHAR(255)");
        $this->execute("ALTER TABLE tradestatus MODIFY label VARCHAR(255)");
        $this->execute("ALTER TABLE tradestatus MODIFY shortname VARCHAR(255)");
        $this->execute("ALTER TABLE sources MODIFY label VARCHAR(255)");
        $this->execute("ALTER TABLE sources MODIFY shortname VARCHAR(255)");
        $this->execute("ALTER TABLE rectypes MODIFY label VARCHAR(255)");
        $this->execute("ALTER TABLE rectypes MODIFY shortname VARCHAR(255)");
        $this->execute("ALTER TABLE recordings MODIFY sourceidentification VARCHAR(255)");
        $this->execute("ALTER TABLE recordings MODIFY taper VARCHAR(255)");
        $this->execute("ALTER TABLE recordings MODIFY transferer VARCHAR(255)");
        $this->execute("ALTER TABLE media MODIFY label VARCHAR(255)");
        $this->execute("ALTER TABLE media MODIFY shortname VARCHAR(255)");
        $this->execute("ALTER TABLE aspectratio MODIFY label VARCHAR(255)");

        $this->execute("ALTER TABLE recordings MODIFY sumlength decimal(8,2)");
        
        //table for signatures
        $this->createTable('signature', array(
            "id" => "pk",
            "name" => "string NOT NULL",
            "enabled" => "BOOL DEFAULT true",
            "additionalText" => "string DEFAULT ''",
            "bgTransparent" => "BOOL DEFAULT false",
            "bgColor" => "VARCHAR(7) NOT NULL",
            "color1" => "VARCHAR(7) NOT NULL",
            "color2" => "VARCHAR(7) NOT NULL",
            "color3" => "VARCHAR(7) NOT NULL",
            "quality" => "INTEGER NOT NULL DEFAULT 9",
            "recordsCount" => "INTEGER NOT NULL DEFAULT 5",
        ));

        //remove unneeded video_id col for table screenshot
        $this->dropForeignKey('screenshot_ibfk_1', 'screenshot');
        $this->dropColumn('screenshot', 'video_id');

        //convert old watermark settings to new ones
        $this->convertWatermarkColor();
        $this->updateFontStyle();
        $this->updateBooleanSettings('watermark_resizeThumbnail');
        $this->updateBooleanSettings('watermark_thumbnail');
        $this->updateBooleanSettings('watermark_textEnabled');

        //set default theme
        Yii::app()->settingsManager->setPropertyValue("theme_name","default");
        
        // convert table collation to utf8
        $dbSchema = $this->dbConnection->schema;
        $dbSchema->refresh();
        $tableNames=$dbSchema->getTableNames();
        foreach ($tableNames as $tableName) {
            $this->convertTable2Utf8($tableName);
        }
        
        Yii::app()->settingsManager->setPropertyValue(DbMigrator::DB_VERSION, self::DB_VERSION);
    }

    private function convertTable2Utf8($tableName) {
        $this->execute("ALTER TABLE ".$tableName." COLLATE utf8_general_ci;");
        $this->execute("ALTER TABLE ".$tableName." CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci;");
    }
    
    /**
     * in previous versions the copyrigthed font "verdana" was used, now it got replaced by free fonts
     */
    private function updateFontStyle() {
        $fontStyle = $this->dbConnection->createCommand()->select('value')->from('settings')->where('property="watermark_fontStyle"')->queryScalar();
        if ($fontStyle !== false) {
            $fonts = Yii::app()->screenshotManager->getFonts();
            if (count($fonts) > 0) {
                $this->update("settings", array("value" => $fonts[0]), 'property="watermark_fontStyle"');
            }
        }
    }

    /**
     * in previous versions color was set with RGB, now hex is used
     */
    private function convertWatermarkColor() {
        $db = $this->dbConnection;
        $red = $db->createCommand()->select('value')->from('settings')->where('property="watermark_red"')->queryScalar();
        $green = $db->createCommand()->select('value')->from('settings')->where('property="watermark_green"')->queryScalar();
        $blue = $db->createCommand()->select('value')->from('settings')->where('property="watermark_blue"')->queryScalar();

        if ($red !== false && $green !== false && $blue !== false) {
            $hexColor = Helper::convertRgbToHex($red, $green, $blue);
            $this->insert("settings", array("property" => "watermark_color", "value" => $hexColor));
        }

        $this->delete("settings", 'property="watermark_red"');
        $this->delete("settings", 'property="watermark_green"');
        $this->delete("settings", 'property="watermark_blue"');
    }

    /**
     *  updates the settings for boolena values (in the past false was saved as a empty string and true was saved as "true" string
     *  now it is 0 and 1
     */
    private function updateBooleanSettings($property) {
        $db = $this->dbConnection;
        $value = $db->createCommand()->select('value')->from('settings')->where('property="' . $property . '"')->queryScalar();

        if (($value !== false) && (strlen($value) == 0 || $value == 'false')) {
            $this->update("settings", array("value" => 0), 'property="' . $property . '"');
        }
        if (($value !== false) && ($value == 'true')) {
            $this->update("settings", array("value" => 1), 'property="' . $property . '"');
        }
    }

    public function safeDown() {
        echo "m130417_000000_phprecdb_1_0 does not support down migration.\n";
        return false;
    }

}

?>
