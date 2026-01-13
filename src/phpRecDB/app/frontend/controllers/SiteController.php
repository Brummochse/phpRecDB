<?php

class SiteController extends BaseController implements PrdServiceProvider {


    protected function getWwwUrlPath()
    {
        return 'phpRecDB/app/www';
    }

    protected function getScreenshotPath()
    {
        return 'phpRecDB/screenshots';
    }

    public function init() {

        $this->layout = 'internal';

        //check if theme is loaded via config file
        if (!isset(Yii::app()->theme)) {
            //load theme from db
            Yii::app()->theme = Yii::app()->settingsManager->getPropertyValue(Settings::THEME_NAME);
        }
        //fallback if selected theme is not available
        if (!isset(Yii::app()->theme)) {
            $themes = Yii::app()->themeManager->themeNames;
            if (count($themes) > 0) {
                if (in_array('default', $themes)) {
                    Yii::app()->theme='default';
                } else {
                    Yii::app()->theme=$themes[0];
                }
            } else {
               throw new Exception('theme is not available.');
            }
        }

        parent::init();
    }

    public function actions() {
        return array(
            'page' => array(
                'class' => 'CViewAction',
            ),
        );
    }

    public function actionIndex() {
        $this->render('pages/index');
    }

    ////////

    private function renderList(ListDataConfig $listDataConfig) {
        $dataFetcher = new RecordsListFetcher($listDataConfig);
        $this->renderPartial('list', array('data' => $dataFetcher->getData()));
        //
        if (ParamHelper::decodeRecordIdParam()==NULL) { //no record detail page, log a "list" as page userVisit
            if (!Uservisit::model()->isBotVisitor()) {
                Uservisit::model()->logPageVisit(get_class($listDataConfig));
            }
        }
    }

    public function printArtistList($artistName) {
        $artistModel = Artist::model()->findByAttributes(array('name' => $artistName));
        if ($artistModel == NULL) {
            echo 'ERROR: artist ' . $artistName . ' not found';
        } else {
            $this->renderList(new RecordsForArtistDataConfig($artistModel->id));
        }
    }

    public function printList($collapsed = true) {
        $this->doPrintList($collapsed);
    }

    public function printNews($newsCount = 5, $newsType = LAST_DAYS) {
        $this->doPrintNews($newsCount, $newsType);
    }

    public function printStatistics() {
        $this->renderPartial('statistics');
        //
        if (!Uservisit::model()->isBotVisitor()) {
            Uservisit::model()->logPageVisit('statistics');
        }
    }

    public function printSubList($sublistName, $collapsed = true) {
        $sublistModel = Sublist::model()->findByAttributes(array('label' => $sublistName));
        if ($sublistModel == NULL) {
            echo 'ERROR: sublist ' . $sublistName . ' not found';
        } else {
            $this->renderList(new SublistListDataConfig($sublistModel->id, $collapsed));
        }
    }

    public function printVideoList($collapsed = true) {
        $this->doPrintList($collapsed, VA::VIDEO);
    }

    public function printAudioList($collapsed = true) {
        $this->doPrintList($collapsed, VA::AUDIO);
    }

    public function printVideoNews($newsCount = 5, $newsType = LAST_DAYS) {
        $this->doPrintNews($newsCount, $newsType, VA::VIDEO);
    }

    public function printAudioNews($newsCount = 5, $newsType = LAST_DAYS) {
        $this->doPrintNews($newsCount, $newsType, VA::AUDIO);
    }

    /////////////////

    private function doPrintList($collapsed, $va = VA::VIDEO_AND_AUDIO) {
        $sublistsToExclude = Sublist::model()->findAllByAttributes(array('exclude' => true));
        $sublistIdsToExclude = array_map(function(Sublist $sublist):int { return $sublist->id; }, $sublistsToExclude);

        $listConfig = new AllListDataConfig($collapsed,false,$sublistIdsToExclude);
        $listConfig->setVideoAudioSelection($va);
        $this->renderList($listConfig);
    }

    private function doPrintNews($newsCount, $newsType, $va = VA::VIDEO_AND_AUDIO) {
        if ($newsType == LAST_DAYS) {
            $listDataConfig = new LastDaysNewsListDataConfig($newsCount);
        } else { // ==LAST_RECORDS
            $listDataConfig = new LastRecordsNewsListDataConfig($newsCount);
        }
        $listDataConfig->setVideoAudioSelection($va);
        $this->renderList($listDataConfig);
    }

}

?>
