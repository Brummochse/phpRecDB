<?php

class WatermarkController extends AdminController {

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

    public function actionIndex() {
        $model = WatermarkForm::createFromSettingsDb();

        if (isset($_POST['WatermarkForm'])) {
            $model->attributes = $_POST['WatermarkForm'];
        }

        $watermarkScreenshotUrl = '';
        $watermarkthumbnailUrl = '';

        if ($model->validate()) {

            if ($model->enable) {
                $watermarkScreenshotPath = Yii::app()->params['miscPath'] . DIRECTORY_SEPARATOR . Yii::app()->params['watermarkTestScreenshot'];
                Yii::app()->screenshotManager->watermarkScreenshot($model, Yii::app()->params['emptyScreenshot'], $watermarkScreenshotPath);
                $watermarkScreenshotUrl = Helper::checkSlashes(Yii::app()->params['miscUrl'] . '/' . Yii::app()->params['watermarkTestScreenshot']);

                if ($model->watermarkThumbnail) {
                    $watermarkThumbnailPath = Yii::app()->params['miscPath'] . DIRECTORY_SEPARATOR . Yii::app()->params['watermarkTestThumbnail'];
                    Yii::app()->screenshotManager->watermarkThumbnail($model, Yii::app()->params['emptyScreenshot'], $watermarkThumbnailPath);
                    $watermarkthumbnailUrl = Helper::checkSlashes(Yii::app()->params['miscUrl'] . '/' . Yii::app()->params['watermarkTestThumbnail']);
                }
            }
            $model->saveToSettingsDb();
        }

        $this->render('index', array(
            'model' => $model, 'watermarkScreenshotUrl' => $watermarkScreenshotUrl, 'watermarkthumbnailUrl' => $watermarkthumbnailUrl
        ));
    }

}
