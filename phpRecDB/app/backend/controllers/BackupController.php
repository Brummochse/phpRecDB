<?php

/**
 * this controller (views/models) is based on the module "backup" by 
 * Shiv Charan Panjeta <shiv@toxsl.com> <shivcharan.panjeta@outlook.com>
 * http://www.yiiframework.com/extension/backup/
 * 
 * all the original files are declared as "version 1.0", but 
 * they were taken from the package "backup_1.3.zip"
 */

/**
 * Backup
 *
 * Yii module to backup, restore databse
 *
 * @version 1.0
 * @author Shiv Charan Panjeta <shiv@toxsl.com> <shivcharan.panjeta@outlook.com>
 */
class BackupController extends AdminController {

    public $layout = '//backup/backupModuleLayout';
    private $backupsPath;
    
    private $backupFilename;
    private $backupFilenameRegex;
    private $bfRegexVersionPart;
    
    public function init() {
        parent::init();
        $this->backupsPath = $this->getPath();

        //sprintf-string, argument1: version, argument2: date
        //arguments_pregmatch:--(_____1____)---(2_)---(3_)---(4_)---(__5_)                          
        $this->backupFilename = "phpRecDB_[" . "%s" . "]_" . "%s" . ".sql";
        //this menas version is saved after preg match in part 2
        $this->bfRegexVersionPart=2;
        
        //test regex if backupfile name is valid for upload
        $this->backupFilenameRegex = '/^(phpRecDB_\[)(.+)(\]_)([0-9\-\._]+)(\.sql)$/';
    }

    private function getPath() {
        $backupsPath = Yii::app()->params['backupPath'];

        if (!file_exists($backupsPath)) {
            mkdir($backupsPath);
            chmod($backupsPath, '777');
        }
        return $backupsPath;
    }

    private function getVersionStr() {
        return  str_replace(' ', '', Yii::app()->params['version']);
    }
    
    private function createBackupName() {
        $version = $this->getVersionStr();
        $date = date('Y-m-d_H.i.s');
        return sprintf($this->backupFilename, $version, $date);
    }

    public function actionCreate() {

        $dbBackup = new DbBackup();
        $backupSqlFilePath = $this->backupsPath . $this->createBackupName();

        if (!$dbBackup->createBackup($backupSqlFilePath)) {
            Yii::app()->user->addMsg(WebUser::ERROR, "couldn't create backup: <br>" . $backupSqlFilePath);
        }

        $this->redirect(array('index'));
    }

    public function actionDelete($file = null) {
        if (isset($file)) {
            $sqlFile = $this->backupsPath . basename($file);
            if (file_exists($sqlFile))
                unlink($sqlFile);
        }
        else
            throw new CHttpException(404, Yii::t('app', 'File not found'));
        $this->actionIndex();
    }

    public function actionDownload($file = null) {
        if (isset($file)) {
            $sqlFile = $this->backupsPath . basename($file);
            if (file_exists($sqlFile)) {
                $request = Yii::app()->getRequest();
                $request->sendFile(basename($sqlFile), file_get_contents($sqlFile));
            }
        }
        throw new CHttpException(404, Yii::t('app', 'File not found'));
    }

    public function actionIndex() {
        $dataArray = array();

        $list_files = glob($this->backupsPath . '*.sql');
        if ($list_files) {
            $list = array_map('basename', $list_files);
            sort($list);

            foreach ($list as $id => $filename) {
                $columns = array();
                $columns['id'] = $id;
                $columns['name'] = basename($filename);
                $columns['size'] = floor(filesize($this->backupsPath . $filename) / 1024) . ' KB';
                $columns['create_time'] = date(DATE_RFC822, filectime($this->backupsPath . $filename));
                $dataArray[] = $columns;
            }
        }
        $dataProvider = new CArrayDataProvider($dataArray);
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    public function actionRestore($file = null) {
        $sqlFile = $this->backupsPath . basename($file);
        $dbBackup = new DbBackup();
        $result = $dbBackup->execSqlFile($sqlFile);
        if ($result === true) {
            $message = 'OK. Done';
        } else {
            $message = $result;
        }
        $this->render('restore', array('error' => $message));
    }

    public function actionUpload() {
        $model = new UploadForm('upload');
        if (isset($_POST['UploadForm'])) {
            $model->attributes = $_POST['UploadForm'];
            $model->upload_file = CUploadedFile::getInstance($model, 'upload_file');

            //check if file exist
            if ($model->upload_file == null) { 
                Yii::app()->user->addMsg(WebUser::ERROR, "no upload file selected");
            } else {
                $fileName = $model->upload_file->name;
                
                //check if filename is correct
                if ((bool) preg_match($this->backupFilenameRegex, $fileName, $matches) === false) {
                    Yii::app()->user->addMsg(WebUser::ERROR, "The Uploaded file is not a compatible phpRecDB backup file.");
                } else {
                    $fileNameVersion = $matches[$this->bfRegexVersionPart];
                    
                    //check if version filename is correct
                    if ($fileNameVersion != $this->getVersionStr()) {
                        Yii::app()->user->addMsg(WebUser::ERROR, "The Uploaded file is not compatible with the current running version.");
                    } else {
                        
                        //save file
                        if ($model->upload_file->saveAs($this->backupsPath . $model->upload_file)) {
                            $this->redirect(array('index'));
                        }
                    }
                } Yii::app()->user->addMsg(WebUser::ERROR, "Could not upload file.");

                $this->redirect(array('index'));
            }
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