<?php

abstract class Renderer {

    protected $controller;

    public function __construct(CController $controller) {
        $this->controller = $controller;
    }

    public function renderList(ListDataConfig $listDataConfig) {
        $dataFetcher = new RecordsListFetcher($listDataConfig);
        $this->renderView('list', array('data' => $dataFetcher->getData()));
        //
        if (ParamHelper::decodeRecordIdParam()==NULL) { //no record detail page, log a "list" as page userVisit
            if (!Uservisit::model()->isBotVisitor()) {
                Uservisit::model()->logPageVisit(get_class($listDataConfig));
            }
        }
    }

    public abstract function renderView($viewName, $options = array());

    public abstract function getLayout();
}

class YiiExternalRenderer extends Renderer {

    public function renderView($viewName, $options = array()) {
        $this->controller->render($viewName, $options);
    }

    public function getLayout() {
        return 'content';
    }

}

class YiiInternalRenderer extends Renderer {

    public function renderView($viewName, $options = array()) {
        $this->controller->renderPartial($viewName, $options);
    }

    public function getLayout() {
        return 'internal';
    }

}

class SiteController extends CController implements PrdServiceProvider {

    private $renderer;
    private $actions = array();

    public function init() {

        if (Yii::app()->listDataConfigurator->isDefaultActionDefined()) {
            //external usage
            $this->renderer = new YiiExternalRenderer($this);
        } else {
            //yii intern usage
            $this->renderer = new YiiInternalRenderer($this);

            $this->actions = array(
                'page' => array(
                    'class' => 'CViewAction',
                ),
            );
        }

        $this->layout = $this->renderer->getLayout();


        //check if theme is loaded via config file
        if (!isset(Yii::app()->theme)) {
            //load theme from db
            $themeModel = new ThemeForm();
            Yii::app()->theme = $themeModel->theme;
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
        return $this->actions;
    }

    public function actionIndex() {
        if (Yii::app()->listDataConfigurator->isDefaultActionDefined()) {

            if (Yii::app()->params['defaultAction'] == 'statistics') {
                $this->printStatistics();
            } else {
                $listDataConfig = Yii::app()->listDataConfigurator->evalListDataConfig();
                if ($listDataConfig != NULL) {
                    $this->renderer->renderList($listDataConfig);
                } else {
                    echo ' ERROR: no valid list data config! ';
                }
            }
        } else {
            $this->render('pages/index');
        }
    }

    ////////

    public function printArtistList($artistName) {
        $artistModel = Artist::model()->findByAttributes(array('name' => $artistName));
        if ($artistModel == NULL) {
            echo 'ERROR: artist ' . $artistName . ' not found';
        } else {
            $this->renderer->renderList(new RecordsForArtistDataConfig($artistModel->id));
        }
    }

    public function printList($collapsed = true) {
        $this->doPrintList($collapsed);
    }

    public function printNews($newsCount = 5, $newsType = LAST_DAYS) {
        $this->doPrintNews($newsCount, $newsType);
    }

    public function printStatistics() {
        $this->renderer->renderView('statistics');
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
            $this->renderer->renderList(new SublistListDataConfig($sublistModel->id, $collapsed));
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
        $listConfig = new AllListDataConfig($collapsed);
        $listConfig->setVideoAudioSelection($va);
        $this->renderer->renderList($listConfig);
    }

    private function doPrintNews($newsCount, $newsType, $va = VA::VIDEO_AND_AUDIO) {
        if ($newsType == LAST_DAYS) {
            $listDataConfig = new LastDaysNewsListDataConfig($newsCount);
        } else { // ==LAST_RECORDS
            $listDataConfig = new LastRecordsNewsListDataConfig($newsCount);
        }
        $listDataConfig->setVideoAudioSelection($va);
        $this->renderer->renderList($listDataConfig);
    }

}

?>
