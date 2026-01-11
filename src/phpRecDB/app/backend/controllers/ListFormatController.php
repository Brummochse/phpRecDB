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
}