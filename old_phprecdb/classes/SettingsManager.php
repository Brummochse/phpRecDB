<?php

class SettingsManager {

    private $settingsTableName = "settings";

    public function SettingsManager() {
        include_once dirname(__FILE__) . "/../settings/dbConnection.php";
        dbConnect();
        $this->ensureSettingsTableExistence();
    }

    public function setPropertyValue($property, $value) {
        $sqlQuery = "REPLACE INTO " . $this->settingsTableName . " (property, value)" .
                " VALUES ('$property', '$value');";
        mysql_query($sqlQuery);
    }

    private function fetchPropertyValue($property) {
        $sqlQuery = "SELECT value FROM " . $this->settingsTableName . "" .
                " WHERE property='$property'";
        $result = mysql_query($sqlQuery);
        if (!$result) {
            //TODO Fehlerbehandung, fehler beim auslesen der Property
            return NULL;
        }
        return $result;
    }

    public function containsProperty($property) {
        $result = $this->fetchPropertyValue($property);
        if ($result==NULL || mysql_num_rows($result) == 0) {
            return false;
        } else {
            return true;
        }
    }

    public function getPropertyValue($property) {
        $result = $this->fetchPropertyValue($property);
        if ($result == NULL) {
            return null;
        }
        $row = mysql_fetch_assoc($result);
        $value = $row['value'];
        return $value;
    }

    private function ensureSettingsTableExistence() {
        if ($this->dataBaseHasTable($this->settingsTableName) == false) {
            $sqlQuery = "CREATE TABLE " . $this->settingsTableName . " (" .
                    "property varchar(255) NOT NULL ," .
                    "value varchar(255) ," .
                    "UNIQUE (property)" .
                    ");";
            mysql_query($sqlQuery);
        };
        if ($this->dataBaseHasTable($this->settingsTableName) == false) {
            //TODO Fehlerbehandung, fehler beim erstellen der tabelle
        };
    }

    private function dataBaseHasTable($tableName) {
        include_once dirname(__FILE__) . "/../settings/dbConfig.php";
        $dbInfo = new DbConfig();
       // $result = mysql_list_tables($dbInfo->getDb());

        $sql = "SHOW TABLES FROM ".$dbInfo->getDb();
        $result = mysql_query($sql);
        if (!$result) {
            echo "DB Error, could not list tables\n";
            echo 'MySQL Error: ' . mysql_error();
            exit;
        }
        while ($row = mysql_fetch_row($result)) {
            if ($tableName == $row[0]) {
                mysql_free_result($result);
                return true;
            }
        }
        mysql_free_result($result);
        return false;
    }

}

?>
