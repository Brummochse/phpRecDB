<?php

class AdminBaseController extends AdminController {

    const ADD_RECORD_FORM_MODEL = "ADD_RECORD_MODEL";

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

    private function renderList($listDataConfig, $title, $listOptionsModel) {
        $dataFetcher = new RecordsListFetcher($listDataConfig);

        $this->render('listRecords', array(
            'title' => $title,
            'data' => $dataFetcher->getData(),
            'listOptionsModel' => $listOptionsModel,
        ));
    }

    private function getListOptionModel($listId) {
        $listOptionsModel = ListOptionsForm::createFromSettingsDb($listId);
        if (isset($_POST['ListOptionsForm'])) {
            $listOptionsModel->attributes = $_POST['ListOptionsForm'];

            if ($listOptionsModel->validate()) {
                $listOptionsModel->saveToSettingsDb();
            }
        }
        return $listOptionsModel;
    }

    public function actionListRecords() {
        $listId = ''; //empty string means "global list"
        $listOptionsModel = $this->getListOptionModel($listId);
        $isAdmin = true;
        $listDataConfig = new AllListDataConfig($listOptionsModel->collapsed, $isAdmin);

        $this->renderList($listDataConfig, 'manage records', $listOptionsModel);
    }

    public function actionSublist() {

        if (($sublistModel = ParamHelper::decodeSublistModel()) != NULL) {
            $listOptionsModel = $this->getListOptionModel($sublistModel->id);
            $isAdmin = true;
            $listDataConfig = new SublistListDataConfig($sublistModel->id, $listOptionsModel->collapsed, $isAdmin);

            $this->renderList($listDataConfig, 'manage sublist: ' . CHtml::encode($sublistModel->label), $listOptionsModel);
        }
        else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
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

    public function actionScreenshotStatistics() {

        $dirIter = new RecursiveDirectoryIterator(Yii::app()->params['screenshotsPath']);
        $recursiveIterator = new RecursiveIteratorIterator($dirIter, RecursiveIteratorIterator::SELF_FIRST, RecursiveIteratorIterator::CATCH_GET_CHILD);

        $filesCount = 0;
        $size = 0;

        foreach ($recursiveIterator as $element) {
            switch ($element->getType()) {
                case 'file':
                    $filesCount++;
                    $size += $element->getSize();
                    break;
            }
        }

        $sizeInMb = sprintf("%.2f", $size / 1024 / 1024);


        $this->render('screenshotStatistics', array(
            'filesCount' => $filesCount, 'filesSize' => $sizeInMb)
        );
    }

    public function actionScreenshotCompression() {
        $model = ScreenshotCompressionForm::createFromSettingsDb();

        if (isset($_POST['ScreenshotCompressionForm'])) {
            $model->attributes = $_POST['ScreenshotCompressionForm'];

            if ($model->validate()) {
                $model->saveToSettingsDb();
            }
        }

        $this->render('screenshotCompression', array(
            'model' => $model)
        );
    }

    private function highlightColListEntry($listElements, $elementsToHighLight, $color) {
        foreach ($elementsToHighLight as $elementToHighLight) {
            if (key_exists($elementToHighLight, $listElements)) {
                $listElements[$elementToHighLight] = "<div style='background:" . $color . ";'>" . $elementToHighLight . "</div>";
            }
        }
        return $listElements;
    }

    public function actionListColConfigBackend() {
        $isFrontendConfig = false;
        $this->processColConfigurator($isFrontendConfig);
    }

    public function actionListColConfigFrontend() {
        $isFrontendConfig = true;
        $this->processColConfigurator($isFrontendConfig);
    }

    /**
     * creates a menu to select which list-cols should be displayed.
     * 
     * @param type $isFrontendConfig if this is true, no backend-cols get displayed
     */
    private function processColConfigurator($isFrontendConfig) {

        if ($isFrontendConfig) {
            $dbSettingsName = ColumnStock::SETTINGS_DB_NAME_FRONTEND;
            $defaults = ColumnStock::SETTINGS_DEFAULT_FRONTEND;
            $title = "Frontend";
        } else { //=backend
            $dbSettingsName = ColumnStock::SETTINGS_DB_NAME_BACKEND;
            $defaults = ColumnStock::SETTINGS_DEFAULT_BACKEND;
            $title = "Administration Panel";
        }

        if (isset($_POST[ParamHelper::PARAM_SELECTED_COLS])) {
            Yii::app()->settingsManager->setPropertyValue($dbSettingsName, $_POST[ParamHelper::PARAM_SELECTED_COLS]);
        }

        $selectedColsStr = Yii::app()->settingsManager->getPropertyValue($dbSettingsName);
        $selectedCols = explode(',', $selectedColsStr);
        $allCols = Cols::getAllColNames();

        if ($isFrontendConfig) {
            $allCols = array_diff($allCols,Cols::$BACKEND_ONLY_COLS);
        }

        $selectedCols = Helper::parallelArray(array_intersect($selectedCols, $allCols)); //ensure that all selected cols really exist (for the case that the string contains a wrong colname)
        $availableCols = Helper::parallelArray(array_diff($allCols, $selectedCols)); //means id and content is the same in the html list


        $selectedCols = $this->highlightColListEntry($selectedCols, Cols::$REQUIRED_COLS, '#88FF88');
        //
        $selectedCols = $this->highlightColListEntry($selectedCols, Cols::$BACKEND_ONLY_COLS, '#FF8888');
        $availableCols = $this->highlightColListEntry($availableCols, Cols::$BACKEND_ONLY_COLS, '#FF8888');

        $this->render('listColConfig', array(
            'colsSelected' => $selectedCols,
            'colsAvailable' => $availableCols,
            'notMoveableCols' => Cols::$REQUIRED_COLS,
            'defaults' => $defaults,
            'title'=>$title)
        );
    }

}