<?php

define("DB_VERSION", "database_version");

include_once dirname(__FILE__) . "/../constants.php";
include_once Constants :: getClassFolder() . "SettingsManager.php";

class DbUpdater {

    private $settingsManager = null;
    private $latestDbVersion = 0;
    private $updates = null;

    public function getLatestDbVersion() {
        return $this->latestDbVersion;
    }

    public function DbUpdater() {
        $this->settingsManager = new SettingsManager();

        $this->loadUpdates();
        $lastUpdate = end($this->updates);
        $this->latestDbVersion = $lastUpdate->getVersion();
    }

    public function getCurrentDbVersion() {

        $result = $this->settingsManager->getPropertyValue(DB_VERSION);
        $dbversion = (float) $result;

        if ($result == NULL || empty($dbversion)) {
            return 0.1;
        } else {
            return $dbversion;
        }
    }

    public function update() {
        $result = false;
        $currentDbVersion = $this->getCurrentDbVersion();
        //if currentDbVersion is not up-to-date
        if ($currentDbVersion < $this->latestDbVersion) {

            include_once Constants :: getSettingsFolder() . "dbConnection.php";
            dbConnect();

            foreach ($this->updates as $update) {

                if ($update->getVersion() > $currentDbVersion) {
                    $update->execute();

                    $this->settingsManager->setPropertyValue(DB_VERSION, $update->getVersion());

                    $result = true;
                }
            }
        };

        return $result;
    }

    ////////////////////////////////////////////

    private function loadUpdates() {
        $this->updates = array(
            new DbVersion02(),
            new DbVersion03(),
            new DbVersion04(),
            new DbVersion05(),
            new DbVersion06()
        );
    }

}

interface IDbVerions {

    public function execute();

    public function getVersion();
}

class DbVersion02 implements IDbVerions {

    public function getVersion() {
        return 0.2;
    }

    public function execute() {

        //erstelle Tabelle lists
        $sqlQuery = "CREATE TABLE IF NOT EXISTS lists (" .
                "	id INTEGER UNSIGNED NOT NULL AUTO_INCREMENT," .
                "	label VARCHAR(255) NOT NULL," .
                "	PRIMARY KEY(id)" .
                ")" .
                "ENGINE=InnoDB;";
        mysql_query($sqlQuery) or die("MySQL-Error: " . mysql_error());

        //erstelle Tabelle sublists
        $sqlQuery = "CREATE TABLE sublists (" .
                "	recordings_id INTEGER NOT NULL," .
                "	lists_id INTEGER UNSIGNED NOT NULL," .
                "	UNIQUE ( recordings_id, lists_id ) ," .
                "	FOREIGN KEY (lists_id) REFERENCES lists(id) ON DELETE CASCADE," .
                "	FOREIGN KEY (recordings_id) REFERENCES recordings(id) ON DELETE CASCADE" .
                ")" .
                "ENGINE=InnoDB;";
        mysql_query($sqlQuery) or die("MySQL-Error: " . mysql_error());

        $sqlQuery = "ALTER TABLE recordings MODIFY created DATETIME;";
        mysql_query($sqlQuery) or die("MySQL-Error: " . mysql_error());

        $sqlQuery = "ALTER TABLE recordings MODIFY lastmodified DATETIME;";
        mysql_query($sqlQuery) or die("MySQL-Error: " . mysql_error());
    }

}

class DbVersion03 implements IDbVerions {

    public function getVersion() {
        return 0.3;
    }

    public function execute() {
        //in the previous version the signature were saved as jpg
        //and jpg quality scale was from 0-100
        //
        //no the signature file use png and png quality scale is from 0-9
        $settingsManager = new SettingsManager();
        $signature_quality = $settingsManager->getPropertyValue('signature_quality');
        if ($signature_quality > 9) {
            $settingsManager->setPropertyValue('signature_quality', 9);
        }
    }

}

class DbVersion04 implements IDbVerions {

    public function getVersion() {
        return 0.4;
    }

    public function execute() {
        // add visibility coloumn to recordings table
        $sqlQuery = "ALTER TABLE recordings ADD visible tinyint(1) DEFAULT 1 AFTER concerts_id;";
        mysql_query($sqlQuery) or die("MySQL-Error: " . mysql_error());

        //add foreing key to screenshot for recording_id
        $sqlQuery = "ALTER TABLE screenshot ADD CONSTRAINT `recordingFK1` " .
                " FOREIGN KEY (video_recordings_id) REFERENCES recordings ( id )";
        mysql_query($sqlQuery) or die("MySQL-Error: " . mysql_error());


        //create table for youtube samples
        $sqlQuery = "CREATE TABLE youtubesamples (" .
                "	id INTEGER UNSIGNED NOT NULL AUTO_INCREMENT," .
                "	title VARCHAR(255)," .
                "	youtubeId VARCHAR(255) NOT NULL," .
                "	recordings_id INTEGER NOT NULL," .
                "	order_id  INT(10) unsigned not null," .
                "	PRIMARY KEY(id)," .
                "	FOREIGN KEY (recordings_id) REFERENCES recordings(id) ON DELETE CASCADE" .
                ")" .
                "ENGINE=InnoDB;";
        mysql_query($sqlQuery) or die("MySQL-Error: " . mysql_error());
    }

}

class DbVersion05 implements IDbVerions {

    public function getVersion() {
        return 0.5;
    }

    public function execute() {
        $settingsManager = new SettingsManager();
        $settingsManager->setPropertyValue('screenshot_compression', true);
    }

}

class DbVersion06 implements IDbVerions {

    public function getVersion() {
        return 0.6;
    }

    public function execute() {

//        $sqlQuery = "DROP TABLE `myuser`;";
//        mysql_query($sqlQuery) or die("MySQL-Error: " . mysql_error());

        $sqlQuery = "CREATE TABLE user (" .
                "	id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT," .
                "	username VARCHAR(255) NOT NULL," .
                "	password VARCHAR(255) NOT NULL," .
                "	salt VARCHAR(255) ," .
                "	email VARCHAR(255) ," .
                "       usergroup INTEGER " .
                ")" .
                "ENGINE=InnoDB;";
        mysql_query($sqlQuery) or die("MySQL-Error: " . mysql_error());

        $sqlQuery = "ALTER TABLE concerts MODIFY supplement VARCHAR(255)";
        mysql_query($sqlQuery) or die("MySQL-Error: " . mysql_error());

        //TODO check if this works
        $sqlQuery = "ALTER TABLE videoformat MODIFY label VARCHAR(255)";
        mysql_query($sqlQuery) or die("MySQL-Error: " . mysql_error());
    }

}

?>
