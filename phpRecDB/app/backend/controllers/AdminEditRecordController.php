<?php

class AdminEditRecordController extends AdminController {

    protected function getScreenshotUploadDate($data, $row) {
        $screenshotFilePath = Yii::app()->params['screenshotsPath'] . DIRECTORY_SEPARATOR . $data->screenshot_filename;

        if (file_exists($screenshotFilePath)) {
            return date('F j, Y', filectime($screenshotFilePath));
        } else {
            return 'error: file missing';
        }
    }

    private function addRecord($va) {
        if (($concertModel = ParamHelper::decodeConcertModel()) != NULL) {
            $newRecordId = Yii::app()->recordManager->addRecordToConcert($va,1 /*1=visible*/, $concertModel);

            Yii::app()->signatureManager->updateSignaturesIfRequired($newRecordId);

            $this->redirect(array('AdminEditRecord/updateRecord', ParamHelper::PARAM_RECORD_ID => $newRecordId));
        }
    }

    public function actionAddVideoRecord() {
        $this->addRecord(VA::VIDEO);
    }

    public function actionAddAudioRecord() {
        $this->addRecord(VA::AUDIO);
    }

    public function actionDeleteRecord() {
        if (($recordModel = ParamHelper::decodeRecordModel()) != NULL) {
            $concertModel = $recordModel->concert;
            $recordModel->delete();

            $firstRecordId = -1;
            if (count($concertModel->records) > 0) {
                $firstRecordId = $concertModel->records[0]->id;
            }

            //delete unused database db entrys
            Yii::app()->dbCleaner->deleteAllUnusedDbEntrys();
            Yii::app()->signatureManager->updateSignatures();

            if ($firstRecordId != -1) {
                $this->redirect(array('AdminEditRecord/updateRecord', ParamHelper::PARAM_RECORD_ID => $firstRecordId));
            } else {
                //should never happen!
            }
        }
    }

    public function actionDeleteScreenshot() {
        if (($screenshotModel = ParamHelper::decodeScreenshotModel()) != NULL) {
            Yii::app()->screenshotManager->deleteScreenshot($screenshotModel);
            $screenshotModel->delete();
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    public function actionMoveUpScreenshot() {
        if (Yii::app()->request->isPostRequest && ($screenshotId = ParamHelper::decodeScreenshotIdParam()) != NULL) {
            Screenshot::model()->moveBefore($screenshotId);
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    public function actionMoveDownScreenshot() {
        if (Yii::app()->request->isPostRequest && ($screenshotId = ParamHelper::decodeScreenshotIdParam()) != NULL) {
            Screenshot::model()->moveBehind($screenshotId);
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    protected function deleteSublistAssignment($data, $row, $param) {
        return Yii::app()->createUrl('adminEditRecord/deleteSublistAssignment', array(ParamHelper::PARAM_SUBLIST_ID => $data->id)); //, ParamHelper::PARAM_RECORD_ID => $recordId));
    }

    protected function renderYoutube($data, $row) {
        $youtubeUrl = 'http://www.youtube.com/v/' . $data->youtubeId;
        return $this->renderPartial('_youtubeItem', array('youtubeUrl' => $youtubeUrl), true, false);
    }

    public function actionDeleteYoutube() {
        if (Yii::app()->request->isPostRequest && ($youtubeModel = ParamHelper::decodeYoutubeModel()) != NULL) {
            $youtubeModel->delete();
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    public function actionMoveDownYoutube() {
        if (Yii::app()->request->isPostRequest && ($youtubeId = ParamHelper::decodeYoutubeIdParam()) != NULL) {
            Youtube::model()->moveBehind($youtubeId);
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    public function actionMoveUpYoutube() {
        if (($youtubeId = ParamHelper::decodeYoutubeIdParam()) != NULL) {
            Youtube::model()->moveBefore($youtubeId);
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again!.');
    }

    private function processTabInformation($recordModel) {
        if ($recordModel->video != NULL) {
            $vaModel = $recordModel->video;
            $vaRecordName = 'Video';
            $vaId = VA::VIDEO;
        } else if ($recordModel->audio != NULL) {
            $vaModel = $recordModel->audio;
            $vaRecordName = 'Audio';
            $vaId = VA::AUDIO;
        } else {
            Yii::app()->user->addMsg(WebUser::ERROR, 'record entry is not connected to a video or audio entry!');
            return '';  //throw new Exception("AdminEditRecordController | processTabInformation : record has no audio/video");
        }

        if (isset($_POST['Record']) && isset($_POST[$vaRecordName])) {
            $recordModel->attributes = Helper::convertNullStrValsToNull($_POST['Record']);
            $vaModel->attributes = Helper::convertNullStrValsToNull($_POST[$vaRecordName]);

            if ($recordModel->validate() && $vaModel->validate()) {
                if ($vaModel->save() && $recordModel->save()) {
                    Yii::app()->signatureManager->updateSignaturesIfRequired($recordModel->id);
                    Yii::app()->user->addMsg(WebUser::INFO, 'record saved successfully!');
                }
            }
        }
        return $this->renderPartial('_information', array('model' => $recordModel, 'vaModel' => $vaModel, 'vaId' => $vaId), true, false);
    }

    private function processTabScreenshot($recordId) {

        if (isset($_POST['Screenshot'])) {
            $screenshotFiles = CUploadedFile::getInstancesByName('screenshots');
            Yii::app()->screenshotManager->proccessUploadedScreenshots($screenshotFiles, $recordId);
        }

        $dataProvider = new CActiveDataProvider('Screenshot', array(
            'criteria' => array(
                'condition' => 'video_recordings_id=' . $recordId,
            ),
            'pagination' => false,
            'sort' => array(
                'defaultOrder' => 'order_id ASC'
            )
        ));

        $screenshotsUrl = Yii::app()->params['screenshotsUrl'];

        return $this->renderPartial('_screenshot', array('dataProvider' => $dataProvider, 'screenshotsUrl' => $screenshotsUrl, 'screenshotModel' => new Screenshot()), true, false);
    }

    private function processTabYoutube($recordId) {
        $createYoutubeFormModel = new CreateYoutubeForm();
        if (isset($_POST['CreateYoutubeForm'])) {
            $createYoutubeFormModel->attributes = $_POST['CreateYoutubeForm'];

            if ($createYoutubeFormModel->validate()) {

                $youtubeModel = new Youtube();
                $youtubeModel->youtubeId = $youtubeModel->extractYoutubeId($createYoutubeFormModel->youtubeUrl);
                $youtubeModel->recordings_id = $recordId;
                $youtubeModel->order_id = Youtube::model()->getOrderIdForNewScreenshot($recordId);
                $youtubeModel->title = $createYoutubeFormModel->title;

                if ($youtubeModel->save()) {
                    $createYoutubeFormModel = new CreateYoutubeForm();
                    Yii::app()->user->addMsg(WebUser::INFO, 'youtube sample saved successfully!');
                }
            }
        }
        $dataProvider = new CActiveDataProvider('Youtube', array(
            'criteria' => array(
                'condition' => 'recordings_id=' . $recordId,
            ),
            'pagination' => false,
            'sort' => array(
                'defaultOrder' => 'order_id ASC'
            )
        ));
        return $this->renderPartial('_youtube', array('dataProvider' => $dataProvider, 'youtubeFormModel' => $createYoutubeFormModel), true, false);
    }

    public function actionDeleteSublistAssignment() {
        if (($sublistId = ParamHelper::decodeSublistIdParam()) != NULL && ($recordId = ParamHelper::decodeRecordIdParam()) != NULL) {
            $sublistAssignmentModel = Sublistassignment::model()->findByAttributes(array('lists_id' => $sublistId, 'recordings_id' => $recordId));
            $sublistAssignmentModel->delete();
            $this->redirect(array('AdminEditRecord/updateSublists', ParamHelper::PARAM_RECORD_ID => $recordId));
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again1.');
    }

    private function processTabSublists($recordModel) {
        $recordId = $recordModel->id;
        if (($sublistId = ParamHelper::decodeIntPostParam(ParamHelper::PARAM_SUBLIST_ID)) != NULL) {

            Record::model()->assignRecordToSublist($recordId, $sublistId);
        }

        $dataProvider = new CActiveDataProvider('Sublistassignment', array(
            'criteria' => array(
                'condition' => 'recordings_id=' . $recordId,
            ),
            'pagination' => false,
        ));

        return $this->renderPartial('_sublists', array('dataProvider' => $dataProvider), true, false);
    }

    public function actionUpdateConcertInfo() {
        $concertFormModel = new ConcertForm;

        if (isset($_POST['ConcertForm']) && ($recordModel = ParamHelper::decodeRecordModel()) != NULL) {
            $concertFormModel->attributes = $_POST['ConcertForm'];
            if ($concertFormModel->validate()) {

                $concertModel = $recordModel->concert;
                $concertModel->fillDataFromConcertFormModel($concertFormModel);

                if ($concertModel->save()) {

                    //updateSignaturesIfRequired is not possible, because we would have to check ALL records of this belonging concert and not only this one
                    Yii::app()->signatureManager->updateSignatures();
                    Yii::app()->user->addMsg(WebUser::INFO, 'concert edit successfully');
                } else {
                    Yii::app()->user->addMsg(WebUser::ERROR, 'concert edit error');
                }

                //delete unused database db entrys
                Yii::app()->dbCleaner->deleteAllUnusedDbEntrys();
            } else {
                $errorMsg = 'errors edit concert:';
                foreach ($concertFormModel->errors as $error) {
                    $errorMsg.='<br />' . (implode(', ', $error));
                }
                Yii::app()->user->addMsg(WebUser::ERROR, $errorMsg);
            }
        }
        $this->actionUpdateRecord();
    }

    public function actionShowRecordStatistics() {
        $this->actionUpdateRecord(Terms::STATISTICS);
    }

    public function actionShowRecordHelper() {
        $this->actionUpdateRecord(Terms::HELPER);
    }

    public function actionUpdateYoutubes() {
        $this->actionUpdateRecord(Terms::YOUTUBE);
    }

    public function actionUpdateScreenshots() {
        $this->actionUpdateRecord(Terms::SCREENSHOT);
    }

    public function actionUpdateSublists() {
        $this->actionUpdateRecord(Terms::SUBLISTS);
    }

    private function processTabStatistics($recordModel) {
        $recordVisit = Recordvisit::model()->getVisitorsForRecord($recordModel);
        return $this->renderPartial('_statistics', array('visitCounter' => $recordVisit->visitors), true, false);
    }

    private function processTabHelper(Record $recordModel) {
        $baseUrl = (isset($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . Yii::app()->baseUrl;
        $helperEndpointUrl=$baseUrl.'/index.php/api/records/'.$recordModel->id;

        return $this->renderPartial('_helper', array('helperEndpointUrl'=>$helperEndpointUrl), true, false);
    }

    /**
     * show the edit record page
     * 
     * IMPORTANT! requires the GET variable PARAM_RECORD_ID to decode the record and concert models
     * 
     * @param string $section
     * @throws CHttpException
     */
    public function actionUpdateRecord($section = Terms::INFORMATION) {
        if (($recordId = ParamHelper::decodeRecordIdParam()) != NULL) {
            $recordModel = Record::model()->findByPk($recordId);

            ///////////////////////////////////
            // tabs
            $informationTabContent = ($section == Terms::INFORMATION) ? $this->processTabInformation($recordModel) : '';
            $screenshotTabContent = ($section == Terms::SCREENSHOT) ? $this->processTabScreenshot($recordId) : '';
            $youtubeTabContent = ($section == Terms::YOUTUBE) ? $this->processTabYoutube($recordId) : '';
            $sublistsTabContent = ($section == Terms::SUBLISTS) ? $this->processTabSublists($recordModel) : '';
            $statisticsTabContent = ($section == Terms::STATISTICS) ? $this->processTabStatistics($recordModel) : '';
            $helperTabContent = ($section == Terms::HELPER) ? $this->processTabHelper($recordModel) : '';

            $tabs = array(
                Terms::INFORMATION => array(
                    'label' => 'Record Information',
                    'url' => ParamHelper::createRecordUpdateUrl($recordId),
                    'content' => $informationTabContent,
                    'active' => $section == Terms::INFORMATION
                ),
                Terms::SUBLISTS => array(
                    'label' => 'Sublists',
                    'url' => ParamHelper::createRecordSublistsUrl($recordId),
                    'content' => $sublistsTabContent,
                    'active' => $section == Terms::SUBLISTS
                ),
            );

            if ($recordModel->video != NULL) {
                $tabs[Terms::SCREENSHOT] = array(
                    'label' => 'Screenshots',
                    'url' => ParamHelper::createRecordScreenshotsUrl($recordId),
                    'content' => $screenshotTabContent,
                    'active' => $section == Terms::SCREENSHOT
                );
                $tabs[Terms::YOUTUBE] = array(
                    'label' => 'Youtube Samples',
                    'url' => ParamHelper::createRecordYoutubesUrl($recordId),
                    'content' => $youtubeTabContent,
                    'active' => $section == Terms::YOUTUBE
                );
            }

            $tabs[Terms::STATISTICS] = array(
                'label' => 'Statistics',
                'url' => ParamHelper::createRecordStatisticsUrl($recordId),
                'content' => $statisticsTabContent,
                'active' => $section == Terms::STATISTICS
            );

            $tabs[Terms::HELPER] = array(
                'label' => 'Helper',
                'url' => ParamHelper::createRecordHelperUrl($recordId),
                'content' => $helperTabContent,
                'active' => $section == Terms::HELPER
            );

            ////////////////////////////////
            // concert info, audio&video record selection menu

            $concertModel = $recordModel->concert;

            $concertInfoStr = (string) $concertModel;
            $recordChoiceMenu = $this->getRecordChoiceMenuItems($concertModel, $recordId);
            $artistListUrl = ParamHelper::createParamUrl('adminBase/listRecords', ParamHelper::PARAM_ARTIST_ID, $concertModel->artist->id);

            $concertForm = $concertModel->getConcertFormModel();

            $this->render('editRecord', array(
                'concertId' => $concertModel->id,
                'recordId' => $recordId,
                'artistName' => $concertModel->artist->name,
                'artistListUrl' => $artistListUrl,
                'concertInfo' => $concertInfoStr,
                'recordChoiceMenuItems' => $recordChoiceMenu['items'],
                'allowDeleteRecord' => ($recordChoiceMenu['recordsCount'] > 1),
                'tabs' => $tabs,
                'concertFormModel' => $concertForm)
            );
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    //function to create a menu item
    private function createItem($recordModel, $selectedRecordId, $sourceIndex) {
        $label = 'source ' . $sourceIndex++ . ': ' . (string) $recordModel;
        $url = ParamHelper::createRecordUpdateUrl($recordModel->id);
        $item = array('label' => $label, 'url' => $url);
        if ($recordModel->id == $selectedRecordId) {
            $item['itemOptions'] = array('class' => 'active');
        }
        return $item;
    }

    //function to create a list of items
    private function createVAItems($vaModels, $recordId, $headerLabel, $sourceIdStart) {
        //
        $items = array();
        if (count($vaModels) > 0) {
            $items[] = array('label' => $headerLabel, 'itemOptions' => array('class' => 'nav-header'));
            foreach ($vaModels as $vaModel) {
                $items[] = $this->createItem($vaModel->record, $recordId, $sourceIdStart++);
            }
        }
        return $items;
    }

    /**
     * @return array ('recordsCount' => number of records, 'items' => items for a menu) 
     */
    private function getRecordChoiceMenuItems($concertModel, $selectedRecordId) {
        $videos = Video::model()->getAllFromConcert($concertModel);
        $audios = Audio::model()->getAllFromConcert($concertModel);

        $itemsVideo = $this->createVAItems($videos, $selectedRecordId, 'Video:', 1);
        $firstAudioSource = count($itemsVideo)==0?1:count($itemsVideo);
        $itemsAudio = $this->createVAItems($audios, $selectedRecordId, 'Audio:', $firstAudioSource);

        $result = array(
            'recordsCount' => count($videos) + count($audios),
            'items' => array_merge($itemsVideo, (array) '', $itemsAudio),
        );
        return $result;
    }

}

?>
