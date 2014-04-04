<?php
/**
 * Backup
 *
 * Yii module to backup, restore databse
 *
 * @version 1.0
 * @author Shiv Charan Panjeta <shiv@toxsl.com> <shivcharan.panjeta@outlook.com>
 */
class DefaultController extends AdminController {

    public $layoutPath;
    public $layout = '//adminBase/backupModuleLayout';

    public function init() {
        $this->layoutPath = Yii::getPathOfAlias('application.views.adminBase');

        parent::init();
    }

    public $tables = array();
    public $fp;
    public $file_name;
    public $_path = null;
    
    //sprintf-string, argument1: version, argument2: date
    private $backupFilename = 'phpRecDB_[%s]_%s.sql';
    //test regex if backupfile name is valid for upload
    private $backupFilenameRegex = '/^(phpRecDB_\[).+(\]_).+(\.sql)$/';
    
    protected function getPath() {
        $this->_path = $this->module->path;

        if (!file_exists($this->_path)) {
            mkdir($this->_path);
            chmod($this->_path, '777');
        }
        return $this->_path;
    }

    public function execSqlFile($sqlFile) {
        $message = "ok";

        if (file_exists($sqlFile)) {
            $sqlArray = file_get_contents($sqlFile);

            $cmd = Yii::app()->db->createCommand($sqlArray);
            try {
                $cmd->execute();
            } catch (CDbException $e) {
                $message = $e->getMessage();
            }
        }
        return $message;
    }

    public function getColumns($tableName) {
        $sql = 'SHOW CREATE TABLE ' . $tableName;
        $cmd = Yii::app()->db->createCommand($sql);
        $table = $cmd->queryRow();

        $create_query = $table['Create Table'] . ';';

        $create_query = preg_replace('/^CREATE TABLE/', 'CREATE TABLE IF NOT EXISTS', $create_query);
        //$create_query = preg_replace('/AUTO_INCREMENT\s*=\s*([0-9])+/', '', $create_query);
        if ($this->fp) {
            $this->writeComment('TABLE `' . addslashes($tableName) . '`');
            $final = 'DROP TABLE IF EXISTS `' . addslashes($tableName) . '`;' . PHP_EOL . $create_query . PHP_EOL . PHP_EOL;
            fwrite($this->fp, $final);
        } else {
            $this->tables[$tableName]['create'] = $create_query;
            return $create_query;
        }
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
            $values = "\n" . $valueString;
            if ($values != "") {
                $data_string .= "INSERT INTO `$tableName` (`$items`) VALUES" . rtrim($values, ",") . ";" . PHP_EOL;
            }
        }

        if ($data_string == '')
            return null;

        if ($this->fp) {
            $this->writeComment('TABLE DATA ' . $tableName);
            $final = $data_string . PHP_EOL . PHP_EOL . PHP_EOL;
            fwrite($this->fp, $final);
        } else {
            $this->tables[$tableName]['data'] = $data_string;
            return $data_string;
        }
    }

    public function getTables($dbName = null) {
        $sql = 'SHOW TABLES';
        $cmd = Yii::app()->db->createCommand($sql);
        $tables = $cmd->queryColumn();
        return $tables;
    }

    private function createBackupName() {
        $version = str_replace(' ', '', Yii::app()->params['version']);
        $date = date('Y.m.d_H.i.s');
        return sprintf($this->backupFilename,$version,$date);
    }
    
    public function StartBackup($addcheck = true) {
        $this->file_name = $this->path . $this->createBackupName() . '.sql';

        $this->fp = fopen($this->file_name, 'w+');

        if ($this->fp == null)
            return false;
        fwrite($this->fp, '-- -------------------------------------------' . PHP_EOL);
        if ($addcheck) {
            fwrite($this->fp, 'SET AUTOCOMMIT=0;' . PHP_EOL);
            fwrite($this->fp, 'START TRANSACTION;' . PHP_EOL);
            fwrite($this->fp, 'SET SQL_QUOTE_SHOW_CREATE = 1;' . PHP_EOL);
        }
        fwrite($this->fp, 'SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;' . PHP_EOL);
        fwrite($this->fp, 'SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;' . PHP_EOL);
        fwrite($this->fp, '-- -------------------------------------------' . PHP_EOL);
        $this->writeComment('START BACKUP');
        return true;
    }

    public function EndBackup($addcheck = true) {
        fwrite($this->fp, '-- -------------------------------------------' . PHP_EOL);
        fwrite($this->fp, 'SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;' . PHP_EOL);
        fwrite($this->fp, 'SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;' . PHP_EOL);

        if ($addcheck) {
            fwrite($this->fp, 'COMMIT;' . PHP_EOL);
        }
        fwrite($this->fp, '-- -------------------------------------------' . PHP_EOL);
        $this->writeComment('END BACKUP');
        fclose($this->fp);
        $this->fp = null;
    }

    public function writeComment($string) {
        fwrite($this->fp, '-- -------------------------------------------' . PHP_EOL);
        fwrite($this->fp, '-- ' . $string . PHP_EOL);
        fwrite($this->fp, '-- -------------------------------------------' . PHP_EOL);
    }

    public function actionCreate() {
        $tables = $this->getTables();

        if (!$this->StartBackup()) {
            //render error
            $this->render('create');
            return;
        }

        foreach ($tables as $tableName) {
            $this->getColumns($tableName);
        }
        foreach ($tables as $tableName) {
            $this->getData($tableName);
        }
        $this->EndBackup();

        $this->redirect(array('index'));
    }

    public function actionDelete($file = null) {
        if (isset($file)) {
            $sqlFile = $this->path . basename($file);
            if (file_exists($sqlFile))
                unlink($sqlFile);
        }
        else
            throw new CHttpException(404, Yii::t('app', 'File not found'));
        $this->actionIndex();
    }

    public function actionDownload($file = null) {
        if (isset($file)) {
            $sqlFile = $this->path . basename($file);
            if (file_exists($sqlFile)) {
                $request = Yii::app()->getRequest();
                $request->sendFile(basename($sqlFile), file_get_contents($sqlFile));
            }
        }
        throw new CHttpException(404, Yii::t('app', 'File not found'));
    }

    public function actionIndex() {
        $path = $this->path;

        $dataArray = array();

        $list_files = glob($path . '*.sql');
        if ($list_files) {
            $list = array_map('basename', $list_files);
            sort($list);

            foreach ($list as $id => $filename) {
                $columns = array();
                $columns['id'] = $id;
                $columns['name'] = basename($filename);
                $columns['size'] = floor(filesize($path . $filename) / 1024) . ' KB';
                $columns['create_time'] = date(DATE_RFC822, filectime($path . $filename));
                $dataArray[] = $columns;
            }
        }
        $dataProvider = new CArrayDataProvider($dataArray);
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    public function actionRestore($file = null) {
        $message = 'OK. Done';
        $sqlFile = $this->path . 'install.sql';
        if (isset($file)) {
            $sqlFile = $this->path . basename($file);
        }

        $this->execSqlFile($sqlFile);
        $this->render('restore', array('error' => $message));
    }

    public function actionUpload() {
        $model = new UploadForm('upload');
        if (isset($_POST['UploadForm'])) {
            $model->attributes = $_POST['UploadForm'];
            $model->upload_file = CUploadedFile::getInstance($model, 'upload_file');
            $fileName=$model->upload_file->name;
            
            if ((bool) preg_match($this->backupFilenameRegex, $fileName) === true) {
                if ($model->upload_file->saveAs($this->path . $model->upload_file)) {
                    $this->redirect(array('index'));
                }
            } else {
                Yii::app()->user->addMsg(WebUser::ERROR, "The Uploaded file is not a compatible phpRecDB backup file.");
            }
            Yii::app()->user->addMsg(WebUser::ERROR, "Could not upload file.");

            $this->redirect(array('index'));
           
        }
        $this->render('upload', array('model' => $model));
    }

    //override the default accessrules from admincontroller
    public function accessRules() {
        return array(
            array('allow',
                'actions' => array('upload', 'restore', 'index', 'download', 'delete', 'create'),
                'roles' => array('admin'),
            ),
            array('deny'),
        );
    }

}