<?php

class AdminBaseController extends AdminController {

    const ADD_RECORD_FORM_MODEL = "ADD_RECORD_MODEL";

    public function actionExistingConcertChoice() {
        if (isset($_POST['choice'])) {
            $addRecordFormModel = Yii::app()->session[self::ADD_RECORD_FORM_MODEL];
            unset(Yii::app()->session[self::ADD_RECORD_FORM_MODEL]);

            $concertModel=null;
            if ($_POST['choice'] === 'newConcert') {
                $concertModel = Yii::app()->recordManager->createNewConcert($addRecordFormModel);
            } else { //=='appendRecord'
                $concertId = $_POST['existingConcerts'];
                $concertModel = Concert::model()->findByPk($concertId);
            }
            $newRecordId = Yii::app()->recordManager->addRecordToConcert($addRecordFormModel->va,$addRecordFormModel->visible, $concertModel);
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
        $listOptionsModel = new ListOptionsForm($listId);
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
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }


    public function actionAddRecord() {
        $addRecordFormModel = new AddRecordForm;
        if (isset($_POST['AddRecordForm'])) {
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
                    $newRecordId = Yii::app()->recordManager->addRecordToConcert($addRecordFormModel->va, $addRecordFormModel->visible, $concertModel);

                    Yii::app()->signatureManager->updateSignaturesIfRequired($newRecordId);

                    if ($newRecordId != NULL) {
                        $this->redirect(array('AdminEditRecord/updateRecord', ParamHelper::PARAM_RECORD_ID => $newRecordId));
                    }
                }
            }
        }
//        $tabItems=$this->getAddRecordTabItems();
//        $tabItems['manually']['content']=$this->renderPartial("_addRecordManually", array('model' => $addRecordFormModel), true);
//        $tabItems['manually']['active']=true;
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
        } else
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
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    public function actionDeleteRecord() {
        if (Yii::app()->request->isPostRequest && ($recordModel = ParamHelper::decodeRecordModel()) != NULL) {
            // we only allow deletion via POST request

            $recordModel->delete();

            //delete unused database db entrys
            Yii::app()->dbCleaner->deleteAllUnusedDbEntrys();
            Yii::app()->signatureManager->updateSignatures();
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    public function actionTheme() {
        $model = new OneValueSettingsForm(Settings::THEME_NAME, 'default', 'theme');

        if (isset($_POST['OneValueSettingsForm'])) {
            $model->attributes = $_POST['OneValueSettingsForm'];

            if ($model->validate()) {
                $model->saveToSettingsDb();
            }
        }

        $this->render('theme', array(
            'model' => $model)
        );
    }

    public function actionUserdefined() {
        $model = new UserdefinedForm();

        if (isset($_POST['UserdefinedForm'])) {
            $model->attributes = $_POST['UserdefinedForm'];

            if ($model->validate()) {
                $model->saveToSettingsDb();
            }
        }
        $this->render('userdefined', array(
            'model' => $model)
        );
    }

    private function getServerInfo() {
        $installed = 'installed';
        $notInstalled = '<div class="alert-danger">not installed</div>';

        $infos = array();
        $infos['PHP_Version'] = phpversion();
        $infos['GD'] = extension_loaded('gd') ? $installed : $notInstalled;
        $infos['GD_FreeType'] = Helper::isGdFreeTypeInstalled() ? $installed : $notInstalled;

        $attributes = array();
        $attributes[] = 'PHP_Version';
        $attributes[] = array('name' => 'GD', 'type' => 'raw');
        $attributes[] = array('name' => 'GD_FreeType', 'type' => 'raw');

        return array('data' => $infos, 'attributes' => $attributes);
    }

    public function actionIndex() {
        $phpRecDbInfo = array();
        $phpRecDbInfo['scriptVersion'] = Yii::app()->params['version'];
        $phpRecDbInfo['databaseVersion'] = Yii::app()->dbMigrator->evalCurrentDbVersion();
        $phpRecDbInfo['YII_Version'] = Yii::getVersion();

        $serverInfos = $this->getServerInfo();

        $this->render('home', array(
            'phpRecDbInfo' => $phpRecDbInfo,
            'serverInfos' => $serverInfos['data'],
            'serverInfoAttributes' => $serverInfos['attributes']
        ));
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
        $model = new OneValueSettingsForm(Settings::SCREENSHOT_COMPRESSION, true, 'Enable Compression');

        if (isset($_POST['OneValueSettingsForm'])) {
            $model->attributes = $_POST['OneValueSettingsForm'];

            if ($model->validate()) {
                $model->saveToSettingsDb();
            }
        }
        $this->render('screenshotCompression', array(
            'model' => $model)
        );
    }

    public function actionListCaching() {
        $model = new OneValueSettingsForm(Settings::LIST_CACHING, false, 'Enable List Caching');

        if (isset($_POST['OneValueSettingsForm'])) {
            $model->attributes = $_POST['OneValueSettingsForm'];

            if ($model->validate()) {
                $model->saveToSettingsDb();
            }
        }


        $this->render('listCaching', array(
            'model' => $model)
        );
    }

    public function actionClearUserStatistics() {
        Uservisit::model()->deleteAll();
        $this->redirect(array('visitorStatistics'));
    }

    public function actionClearRecordVisitStatistics() {
        Recordvisit::model()->deleteAll();
        $this->redirect(array('visitorStatistics'));
    }

    public function actionVisitorStatisticsDetail() {
        if (($visitorIp = ParamHelper::decodeStringGetParam(Terms::IP)) != NULL) {
            $userVisits = Uservisit::model()->findAllByAttributes(array('ip' => $visitorIp), array('order' => 'date DESC'));

            //
            $visitedPages = array();
            $id = 0;
            foreach ($userVisits as $userVisit) {
                $id++;
                if ($userVisit->record_id != NULL) { //record visit
                    $record = Record::model()->findByPk($userVisit->record_id);
                    if ($record != NULL) {
                        $visitedPageLabel = '<b>' . $record->concert->artist->name . '</b> <i>' . $record->concert . '</i> ' . $record;
                    } else {
                        $visitedPageLabel = 'deleted record';
                    }
                } else { // page visit
                    $visitedPageLabel = '<span style="color:blue;">page: ' . $userVisit->page . '</span>';
                }
                $visitedPages[] = array('id' => $id, 'pageLabel' => $visitedPageLabel, 'date' => $userVisit->date);
            }
            //
            $ipLookUpUrlRaw = Yii::app()->params['ipLookupUrl'];
            $ipPlaceholder = Yii::app()->params['ipPlaceHolder'];
            $ipLookUpUrl = str_replace($ipPlaceholder, $visitorIp, $ipLookUpUrlRaw);

            $this->render('visitorStatisticsDetail', array('ipLookUpUrl' => $ipLookUpUrl, 'ip' => $visitorIp, 'visitedPages' => new CArrayDataProvider($visitedPages)));
        }
    }

    public function actionVisitorStatistics() {
        $dbC = Yii::app()->db->createCommand();
        $dbC->distinct = true;
        $dbC->select('id, ip as ' . Terms::IP . ',count(ip) as ' . Terms::COUNT . ',Max(date) ' . Terms::LAST_VISITED);
        $dbC->from('uservisit');
        $dbC->order('MAX( date ) DESC');
        $dbC->group('ip');
        $results = $dbC->queryAll();

        $this->render('visitorStatistics', array('data' => new CArrayDataProvider($results)));
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
            $dbSettingsName = Settings::LIST_COLS_FRONTEND;
            $defaults = ColumnStock::SETTINGS_DEFAULT_FRONTEND;
            $title = "Frontend";
        } else { //=backend
            $dbSettingsName = Settings::LIST_COLS_BACKEND;
            $defaults = ColumnStock::SETTINGS_DEFAULT_BACKEND;
            $title = "Administration Panel";
        }
        if (isset($_POST[ParamHelper::PARAM_SELECTED_COLS])) {
            Yii::app()->settingsManager->setPropertyValue($dbSettingsName, $_POST[ParamHelper::PARAM_SELECTED_COLS]);

            //empty cache, because some changes of the cols are not recognized by the list-content hash algorithm
            Yii::app()->cache->flush();
        }
        $selectedColsStr = Yii::app()->settingsManager->getPropertyValue($dbSettingsName);
        $selectedCols = explode(',', $selectedColsStr);
        $allCols = Cols::getAllColNames();

        if ($isFrontendConfig) {
            $allCols = array_diff($allCols, Cols::$BACKEND_ONLY_COLS);
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
            'title' => $title)
        );
    }

    public function actionWatermark() {
        $model = new WatermarkForm();

        if (!Helper::isGdFreeTypeInstalled()) {
            Yii::app()->user->addMsg(WebUser::ERROR, "Watermark feature can't be used on this server. GD library extension FreeType is not installed.");
            $model->enable = false;
            $model->saveToSettingsDb();
            $this->redirect(array('adminBase/Index'));
        } else {
            if (isset($_POST['WatermarkForm'])) {
                $model->attributes = $_POST['WatermarkForm'];
            }
            $watermarkScreenshotUrl = '';
            $watermarkthumbnailUrl = '';

            if ($model->validate()) {

                if ($model->enable) {

                    $destFileInfo = new FileInfo();
                    $destFileInfo->dir = Yii::app()->params['miscPath'] . DIRECTORY_SEPARATOR;

                    $path_parts = pathinfo(Yii::app()->params['watermarkTestScreenshot']);
                    $destFileInfo->fileNameBase = $path_parts['basename'];
                    $destFileInfo->fileExtension = $path_parts['extension'];
                    $destFileName = Yii::app()->screenshotManager->watermarkScreenshot($model, Yii::app()->params['emptyScreenshot'], $destFileInfo);
                    $watermarkScreenshotUrl = Helper::checkSlashes(Yii::app()->params['miscUrl'] . '/' . $destFileName);

                    if ($model->watermarkThumbnail) {
                        $path_parts = pathinfo(Yii::app()->params['watermarkTestThumbnail']);
                        $destFileInfo->fileNameBase = $path_parts['basename'];
                        $destFileInfo->fileExtension = $path_parts['extension'];
                        $destFileName = Yii::app()->screenshotManager->watermarkThumbnail($model, Yii::app()->params['emptyScreenshot'], $destFileInfo);
                        $watermarkthumbnailUrl = Helper::checkSlashes(Yii::app()->params['miscUrl'] . '/' . $destFileName);
                    }
                }
                $model->saveToSettingsDb();
            }
            $this->render('watermark', array(
                'model' => $model, 'watermarkScreenshotUrl' => $watermarkScreenshotUrl, 'watermarkthumbnailUrl' => $watermarkthumbnailUrl
            ));
        }
    }

}
