<?php

class ListFormatController extends AdminController
{
    public function actionLocationFormat() {

        $model = new OneValueSettingsForm(Settings::LOCATION_FORMAT_PATTERN, 'default', 'Location Format');

        if (isset($_POST['OneValueSettingsForm'])) {
            $model->attributes = $_POST['OneValueSettingsForm'];

            if ($model->validate()) {
                $model->saveToSettingsDb();
            }
        }

        $this->render('locationFormat', array(
                'model' => $model)
        );
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
     * @param bool $isFrontendConfig if this is true, no backend-cols get displayed
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

    private function highlightColListEntry($listElements, $elementsToHighLight, $color) {
        foreach ($elementsToHighLight as $elementToHighLight) {
            if (key_exists($elementToHighLight, $listElements)) {
                $listElements[$elementToHighLight] = "<div style='background:" . $color . ";'>" . $elementToHighLight . "</div>";
            }
        }
        return $listElements;
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

}