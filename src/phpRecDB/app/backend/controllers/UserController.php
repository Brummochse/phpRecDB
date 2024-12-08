<?php

class UserController extends AdminController {

    //override the default accessrules from admincontroller
    public function accessRules() {
        return array(
            array('allow',
                'actions' => array('changePassword', 'profile'),
                'roles' => array('user'),
            ),
            array('allow',
                'actions' => array('admin', 'update', 'create', 'delete'),
                'roles' => array('admin'),
            ),
            array('deny'),
        );
    }

    protected function getRoles() {
        $roles = array_keys(Yii::app()->authManager->roles);
        return array_combine($roles, $roles);
    }

    public function actionProfile() {
        $id = Yii::app()->user->id;
        $this->render('profile', array(
            'model' => $this->loadModel($id),
        ));
    }

    public function actionCreate() {
        $model = new User;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['User'])) {
            $model->attributes = $_POST['User'];

            $model->salt = $model->generateSalt();
            if ($model->password != NULL && strlen($model->password) > 0) {
                $model->password = $model->hashPassword($model->password, $model->salt);
            }

            if ($model->validate() && $model->save()) {
                $this->redirect(array('admin'));
            }
        }

        $this->render('cu', array(
            'model' => $model,
        ));
    }

    private function update($id,$view,$successAction) {
        $model = $this->loadModel($id);

        if (isset($_POST['User'])) {
            $model->attributes = $_POST['User'];

            $model->salt = $model->generateSalt();
            if ($model->password != NULL && strlen($model->password) > 0) {
                $model->password = $model->hashPassword($model->password, $model->salt);
            }

            if ($model->validate() && $model->save())
                $this->redirect(array($successAction));
        }

        $model->password = '';

        $this->render($view, array(
            'model' => $model,
        ));
    }
    
    public function actionChangePassword() {
        $id = Yii::app()->user->id;
        $this->update($id, 'changePassword', 'profile');
    }

    public function actionUpdate($id) {
        $this->update($id, 'cu', 'admin');
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        $model = $this->loadModel($id);

        if (Yii::app()->user->name == $model->username) {
            throw new CHttpException(404, 'You cannot delete yourself.');
        }
        $model->delete();
        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new User('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['User']))
            $model->attributes = $_GET['User'];

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
        $model = User::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

}
