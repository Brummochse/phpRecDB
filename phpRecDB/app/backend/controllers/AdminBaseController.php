<?php

class AdminBaseController extends AdminController {

    const ADD_RECORD_FORM_MODEL = "ADD_RECORD_MODEL";

    public function filters() {
        return array(
            'accessControl',
        );
    }

    public function accessRules() {
        return array(
            array('allow', // allow authenticated users to access all actions
                'users' => array('@'),
            ),
            array('deny'),
        );
    }

    public function actionSublist() {

        if (($sublistModel = ParamHelper::decodeSublistModel()) != NULL) {

            $isCollapsed = true;
            $isAdmin = true;
            $listDataConfig = new SublistListDataConfig($sublistModel->id, $isCollapsed, $isAdmin);
            $dataFetcher = new RecordsListFetcher($listDataConfig);


            $this->render('listRecords', array(
                'title' => 'manage sublist: ' . CHtml::encode($sublistModel->label),
                'data' => $dataFetcher->getData(),
            ));
        }
        else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    public function actionExistingConcertChoice() {
        if (isset($_POST['choice'])) {
            $addRecordFormModel = Yii::app()->session[self::ADD_RECORD_FORM_MODEL];
            unset(Yii::app()->session[self::ADD_RECORD_FORM_MODEL]);

            if ($_POST['choice'] === 'newConcert') {
                $concertModel = Yii::app()->recordManager->createNewConcert($addRecordFormModel);
                $newRecordId = Yii::app()->recordManager->addRecordToConcert($addRecordFormModel->va, $concertModel);
            } else { //=='appendRecord'
                $concertId = $_POST['existingConcerts'];
                $concertModel = Concert::model()->findByPk($concertId);
                $newRecordId = Yii::app()->recordManager->addRecordToConcert($addRecordFormModel->va, $concertModel);
            }
            if ($newRecordId != NULL) {

                Yii::app()->signatureManager->updateSignaturesIfRequired($newRecordId);

                $this->redirect(array('AdminEditRecord/updateRecord', ParamHelper::PARAM_RECORD_ID => $newRecordId));
            }
        }
        $this->render('home');
    }

    public function actionListRecords() {
        $isCollapsed = true;
        $isAdmin = true;
        $listDataConfig = new AllListDataConfig($isCollapsed, $isAdmin);
        $dataFetcher = new RecordsListFetcher($listDataConfig);

        $this->render('listRecords', array(
            'title' => 'manage records',
            'data' => $dataFetcher->getData(),
        ));
    }

    public function actionAddRecord() {
        $addRecordFormModel = new AddRecordForm;
        if (isset($_POST['AddRecordForm'])) {
            //$addRecordFormModel->attributes = $_POST['AddRecordForm'];
            $addRecordFormModel->setAttributes($_POST['AddRecordForm']);

            if ($addRecordFormModel->validate()) {

                $existingConcerts = Concert::model()->searchExistingConcerts($addRecordFormModel->artist, $addRecordFormModel->date, $addRecordFormModel->misc);

                if (count($existingConcerts) > 0) { //check if there exist already concert(s)
                    //save add record data for future use
                    Yii::app()->session[self::ADD_RECORD_FORM_MODEL] = $addRecordFormModel;

                    $newConcertStr = Concert::generateString($addRecordFormModel->artist, $addRecordFormModel->date, $addRecordFormModel->country, $addRecordFormModel->city, $addRecordFormModel->venue, $addRecordFormModel->supplement, $addRecordFormModel->misc);

                    //preprocess concert data for html radio buttons 
                    //array (concertId=>concert label)
                    $existingConcertsHtmlData = array();
                    foreach ($existingConcerts as $concert) {
                        $existingConcertsHtmlData[$concert->id] = (string) $concert;
                    }

                    $this->render('existingConcertChoice', array(
                        'existingConcerts' => $existingConcertsHtmlData,
                        'selection' => key($existingConcertsHtmlData),
                        'newConcert' => $newConcertStr
                    ));
                    return;
                } else {

                    $concertModel = Yii::app()->recordManager->createNewConcert($addRecordFormModel);
                    $newRecordId = Yii::app()->recordManager->addRecordToConcert($addRecordFormModel->va, $concertModel);

                    Yii::app()->signatureManager->updateSignaturesIfRequired($newRecordId);

                    if ($newRecordId != NULL) {
                        $this->redirect(array('AdminEditRecord/updateRecord', ParamHelper::PARAM_RECORD_ID => $newRecordId));
                    }
                }
            }
        }

        $this->render('addRecord', array('model' => $addRecordFormModel));
    }

    public function actionAssignRecordsToSublist() {
        if (Yii::app()->request->isPostRequest) {
            if (isset($_POST[Terms::CHECKBOX_ID]) && ($sublistId = ParamHelper::decodeIntPostParam(ParamHelper::PARAM_SUBLIST_ID)) != NULL) {
                $recodIds = $_POST[Terms::CHECKBOX_ID];
                if (is_array($recodIds)) {
                    foreach ($recodIds as $recordId) {
                        Record::model()->assignRecordToSublist($recordId, $sublistId);
                    }
                }
            }
        }
        else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    public function actionDeleteRecords() {
        if (Yii::app()->request->isPostRequest) {
            if (isset($_POST[Terms::CHECKBOX_ID])) {
                $recodIds = $_POST[Terms::CHECKBOX_ID];
                if (is_array($recodIds)) {
                    foreach ($recodIds as $recordId) {
                        $recordModel = Record::model()->findByPk($recordId);
                        $recordModel->delete();
                    }

                    //delete unused database db entrys
                    Yii::app()->dbCleaner->deleteAllUnusedDbEntrys();
                    Yii::app()->signatureManager->updateSignatures();
                }
            }
        }
        else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    public function actionDeleteRecord() {
        if (Yii::app()->request->isPostRequest && ($recordModel = ParamHelper::decodeRecordModel()) != NULL) {
            // we only allow deletion via POST request

            $recordModel->delete();

            //delete unused database db entrys
            Yii::app()->dbCleaner->deleteAllUnusedDbEntrys();
            Yii::app()->signatureManager->updateSignatures();
        }
        else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    public function actionTheme() {
        $model = ThemeForm::createFromSettingsDb();

        if (isset($_POST['ThemeForm'])) {
            $model->attributes = $_POST['ThemeForm'];

            if ($model->validate()) {
                $model->saveToSettingsDb();
            }
        }

        $this->render('theme', array(
            'model' => $model)
        );
    }

    public function actionIndex() {
        $dbSchemaVersion = Yii::app()->dbMigrator->evalCurrentDbVersion();
        $scriptVersion = Yii::app()->params['version'];

        $this->render('home', array('scriptVersion' => $scriptVersion, 'dbVersion' => $dbSchemaVersion));
    }

    public function actionLogout() {
        Yii::app()->user->logout();
        $this->redirect(Yii::app()->user->loginUrl);
    }

}