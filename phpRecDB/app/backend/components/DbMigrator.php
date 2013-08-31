<?php

require(YII_PATH . '/cli/commands/MigrateCommand.php');

class DbMigrator extends MigrateCommand {
    // migration result status

    const NONE = 0; //no updates available
    const FAILED = 1;
    const SUCCESS = 2;
    const DB_VERSION = "database_version";

    private $oldUpdatesMigrationMap = array(
        'm130416_000001_phprecdb_0_2' => 0.2,
        'm130416_000002_phprecdb_0_3' => 0.3,
        'm130416_000003_phprecdb_0_4' => 0.4,
        'm130416_000004_phprecdb_0_5' => 0.5);

    public function __construct() {
        parent::__construct(NULL, NULL);

        $this->migrationPath = Yii::getPathOfAlias($this->migrationPath);
        $this->migrationTable = 'dbmigration';
    }

    /**
     * phpRecDB Versions 0.1 - 0.6 used another db updating strategy
     * the migration files contain all db schema changes from version 0.1 to the currect version.
     * this means all updeates done with the old updater must not executed again.
     * 
     * this method manipulates the dbmigration table and marks all old updates as already done 
     * (because this updates were sone already with the old updater)
     */
    private function ensureOldUpdaterComtability() {
        $newMigrations = $this->getNewMigrations();
        //$historyMigrations = $this->getMigrationHistory(-1);
        $curDbVersion = $this->evalCurrentDbVersion();

        foreach ($this->oldUpdatesMigrationMap as $migration => $version) {

            if ($curDbVersion >= $version && in_array($migration, $newMigrations)) {

                $command = Yii::app()->db->createCommand();
                $command->insert($this->migrationTable, array(
                    'version' => $migration,
                    'apply_time' => time(),
                ));
            }
        }
    }

    /**
     * @return array (<migration result status> => <migration log>)
     */
    public function runMigrations() {
        $this->ensureOldUpdaterComtability();

        ob_start();
        $migrations = $this->getNewMigrations();

        if (count($migrations) == 0) {
            return array(self::NONE => ob_get_clean());
        }

        foreach ($migrations as $migration) {
            if ($this->migrateUp($migration) === false) {
                echo "\nMigration failed. All later migrations are canceled.\n";
                return array(self::FAILED => nl2br(ob_get_clean()));
            }
        }
        echo "\nMigrated up successfully.\n";
        return array(self::SUCCESS => nl2br(ob_get_clean()));
    }

    public function evalCurrentDbVersion() {

        $result = Yii::app()->settingsManager->getPropertyValue(self::DB_VERSION);
        $dbversion = (float) $result;

        if ($result == NULL || empty($dbversion)) {
            Yii::app()->settingsManager->setPropertyValue(self::DB_VERSION, 0.1);
            return $this->evalCurrentDbVersion();
        } else {
            return $dbversion;
        }
    }

    public function isDbUpToDate() {
        $migrations = $this->getNewMigrations();
        return count($migrations) == 0;
    }
    
    /**
     *  have to overwrite this function because it throws errors on this old code:
     *  "$db=$this->getDbConnection();
	if($db->schema->getTable($this->migrationTable)===null)"
     * 
     * solved it with this replacement:
     *  "$exists=Yii::app()->db->createCommand("SHOW TABLES LIKE '".$this->migrationTable."'")->queryScalar();
        if (!$exists) {"
     * 
     * @param type $limit
     * @return type
     */
    protected function getMigrationHistory($limit) {
        
        $exists=Yii::app()->db->createCommand("SHOW TABLES LIKE '".$this->migrationTable."'")->queryScalar();
        if (!$exists) {
            ob_start(); //surrounded with ob_start&ob_get_clean to avoid this message: "Creating migration history table "dbmigration"...done. " -> causing error with alreday sended header
            $this->createMigrationHistoryTable();
            ob_get_clean();
        }
        return CHtml::listData(Yii::app()->db->createCommand()
                                ->select('version, apply_time')
                                ->from($this->migrationTable)
                                ->order('version DESC')
                                ->limit($limit)
                                ->queryAll(), 'version', 'apply_time');
    }
    
    /**
     * this function gets called with onBeginRequest-event.
     * if db is not up to date, user got logged out (=>new login forces db upgrade)
     * 
     * @param type $event
     */
    public static function checkDbState($event) {
        if (!Yii::app()->dbMigrator->isDbUpToDate()) {
            Yii::app()->user->logout();
        }
    }

}

?>
