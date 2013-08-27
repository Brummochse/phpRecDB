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

        $this->render('index', array(
            'model' => $model, 'watermarkScreenshotUrl' => $watermarkScreenshotUrl, 'watermarkthumbnailUrl' => $watermarkthumbnailUrl
        ));
    }

}
