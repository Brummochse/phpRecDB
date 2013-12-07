<?php

class SiteController extends CController {

    public function actionIndex() {
        $this->render("index", array('model' => new MyModel()));
    }

    /**
     * Handles resource upload
     * @throws CHttpException
     */
    public function actionUpload() {
//        xdebug_break();
        header('Vary: Accept');
        if (isset($_SERVER['HTTP_ACCEPT']) &&
                (strpos($_SERVER['HTTP_ACCEPT'], 'application/json') !== false)) {
            header('Content-type: application/json');
        } else {
            header('Content-type: text/plain');
        }
        $data = array();

        $model = new MyModel('upload');
        $model->picture = CUploadedFile::getInstance($model, 'picture');
        if ($model->picture !== null && $model->validate(array('picture'))) {
            $model->picture->saveAs(
                    Yii::getPathOfAlias('screenshots') . '/' . $model->picture->name);
            $model->file_name = $model->picture->name;
            // save picture name
            if (true) {
                // return data to the fileuploader
                $data[] = array(
                    'name' => $model->picture->getName(),
                    'type' => $model->picture->getType(),
                    'size' => $model->picture->getSize(),
                    // we need to return the place where our image has been saved
                   // 'url' => $model->getImageUrl(), // Should we add a helper method?
                    // we need to provide a thumbnail url to display on the list
                    // after upload. Again, the helper method now getting thumbnail.
                  //  'thumbnail_url' => $model->getImageUrl(MyModel::IMG_THUMBNAIL),
                    // we need to include the action that is going to delete the picture
                    // if we want to after loading 
                   // 'delete_url' => $this->createUrl('my/delete', array('id' => $model->id, 'method' => 'uploader')),
                   // 'delete_type' => 'POST'
                    );
            } else {
                $data[] = array('error' => 'Unable to save model after saving picture');
            }
        } else {
            if ($model->hasErrors('picture')) {
                $data[] = array('error', $model->getErrors('picture'));
            } else {
                throw new CHttpException(500, "Could not upload file " . CHtml::errorSummary($model));
            }
        }
        // JQuery File Upload expects JSON data
        echo json_encode($data);
    }

}

?>
