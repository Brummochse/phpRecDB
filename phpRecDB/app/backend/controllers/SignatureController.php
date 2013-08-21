<?php

class SignatureController extends AdminController {

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

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id = NULL) {
        $model = $this->loadModel($id);
        if ($model == NULL) {
            $model = new Signature;
        }

        if (isset($_POST['Signature'])) {
            $model->attributes = $_POST['Signature'];
            if ($model->save()) {
                $model = $this->loadModel($model->id);
            }
        }

        $pushParams = array('model' => $model);

        if ($model->validate())
            Yii::app()->signatureManager->generateSignature($model);
        
        if (!$model->isNewRecord && $model->enabled) {
            $staticSidDirUrl = $this->getStaticSigDirUrl($model->name);
            $pushParams['signatureStaticUrl'] = $staticSidDirUrl . '/' . SignatureManager::SIG_FILENAME;
            $pushParams['signatureDynamicUrl'] = $staticSidDirUrl;
        }

        $this->render('update', $pushParams);
    }

    private function getStaticSigDirUrl($signatureName) {
        $sigDir = $signatureName . '.png';

        $sigDirUrl = Yii::app()->params['miscUrl'] . '/' .
                SignatureManager::ALLSIGS_DIR . '/' .
                $sigDir;
        return $sigDirUrl;
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        $model = $this->loadModel($id);

         Yii::app()->signatureManager->deleteSignature($model);

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }


    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new Signature('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Signature']))
            $model->attributes = $_GET['Signature'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id) {
        $model = Signature::model()->findByPk($id);
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'signature-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
