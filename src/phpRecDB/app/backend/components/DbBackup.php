<?php

class DbBackup {

    private $fileResource = null;

    /**
     * @param type $sqlFile
     * @return boolen (true) when sql execution was ok, string (errormessage) when execution failed
     */
    public function execSqlFile($sqlFile) {
        if (file_exists($sqlFile)) {
            $sqlArray = file_get_contents($sqlFile);

            $cmd = Yii::app()->db->createCommand($sqlArray);
            try {
                $cmd->execute();
            } catch (CDbException $e) {
                return $e->getMessage();
            }
        }
        return true;
    }

    public function getColumns($tableName) {
        $sql = 'SHOW CREATE TABLE ' . $tableName;
        $cmd = Yii::app()->db->createCommand($sql);
        $table = $cmd->queryRow();

        $create_query = $table['Create Table'] . ';';

        $create_query = preg_replace('/^CREATE TABLE/', 'CREATE TABLE IF NOT EXISTS', $create_query);
        //$create_query = preg_replace('/AUTO_INCREMENT\s*=\s*([0-9])+/', '', $create_query);

        $this->writeComment('TABLE `' . addslashes($tableName) . '`');
        $final = 'DROP TABLE IF EXISTS `' . addslashes($tableName) . '`;' . PHP_EOL . $create_query . PHP_EOL . PHP_EOL;
        $this->writeToFile($final);
    }

    public function getData($tableName) {
        $sql = 'SELECT * FROM ' . $tableName;
        $cmd = Yii::app()->db->createCommand($sql);
        $dataReader = $cmd->query();

        $data_string = '';

        foreach ($dataReader as $data) {
            $itemNames = array_keys($data);
            $itemNames = array_map("addslashes", $itemNames);
            $items = join('`,`', $itemNames);
            $itemValues = array_values($data);
            $itemValues = array_map("addslashes", $itemValues);
            $valueString = join("','", $itemValues);
            $valueString = "('" . $valueString . "'),";
            $values = PHP_EOL . $valueString;
            if ($values != "") {
                $data_string .= "INSERT INTO `$tableName` (`$items`) VALUES" . rtrim($values, ",") . ";" . PHP_EOL;
            }
        }

        if ($data_string == '')
            return;

        $this->writeComment('TABLE DATA ' . $tableName);
        $final = $data_string . PHP_EOL . PHP_EOL . PHP_EOL;
        $this->writeToFile($final);
    }

    public function getTables() {
        $sql = 'SHOW TABLES';
        $cmd = Yii::app()->db->createCommand($sql);
        $tables = $cmd->queryColumn();
        return $tables;
    }

    public function StartBackup($addcheck = true) {
        $this->writeToFile('-- -------------------------------------------' . PHP_EOL);
        if ($addcheck) {
            $this->writeToFile('SET AUTOCOMMIT=0;' . PHP_EOL);
            $this->writeToFile('START TRANSACTION;' . PHP_EOL);
            $this->writeToFile('SET SQL_QUOTE_SHOW_CREATE = 1;' . PHP_EOL);
        }
        $this->writeToFile('SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;' . PHP_EOL);
        $this->writeToFile('SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;' . PHP_EOL);
        $this->writeToFile('-- -------------------------------------------' . PHP_EOL);
        $this->writeComment('START BACKUP');
    }

    public function EndBackup($addcheck = true) {
        $this->writeToFile('-- -------------------------------------------' . PHP_EOL);
        $this->writeToFile('SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;' . PHP_EOL);
        $this->writeToFile('SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;' . PHP_EOL);

        if ($addcheck) {
            $this->writeToFile('COMMIT;' . PHP_EOL);
        }
        $this->writeToFile('-- -------------------------------------------' . PHP_EOL);
        $this->writeComment('END BACKUP');
    }

    public function writeComment($string) {
        $this->writeToFile('-- -------------------------------------------' . PHP_EOL);
        $this->writeToFile('-- ' . $string . PHP_EOL);
        $this->writeToFile('-- -------------------------------------------' . PHP_EOL);
    }

    private function writeToFile($string) {
        fwrite($this->fileResource, $string);
    }

    public function createBackup($backupSqlFilePath) {
        $tables = $this->getTables();

        $this->fileResource = @fopen($backupSqlFilePath, 'w+'); //suspress warning when file can't open

        if ($this->fileResource == null)
            return false;

        $this->StartBackup();

        foreach ($tables as $tableName) {
            $this->getColumns($tableName);
        }
        foreach ($tables as $tableName) {
            $this->getData($tableName);
        }

        $this->EndBackup();

        fclose($this->fileResource);
        $this->fileResource = null;

        return true;
    }

}

?>
