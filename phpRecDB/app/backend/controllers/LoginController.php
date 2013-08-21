<?php

class LoginController extends CController {

    private $defaultAdminWarning = "<div >Use <span style='color:red;font-weight:bolder;'>admin/secret</span> as Username/Passwort and <span style='color:red;font-weight:bolder;'>CHANGE YOUR LOGIN!</span></div>";
    private $defaultDemoWarning = "<div >Use <span style='color:red;font-weight:bolder;'>demo/secret</span> as Username/Passwort</div>";

    public function actionIndex() {
        $this->redirect(array('adminBase/index'), false);
    }

    public function actionLogin() {
        if (!Yii::app()->dbMigrator->isDbUpToDate()) {
            $this->render('dbUpgradeStart');
        } else {

            $welcomeMessage = $this->checkDefaultLogin();
            //
            $model = new LoginForm();
            if (isset($_POST['LoginForm'])) {
                $model->attributes = $_POST['LoginForm'];
                if ($model->validate() && $model->login()) {
                    $this->redirect(array('adminBase/Index'));
                }
            }
            //
            $this->render('login', array('model' => $model, 'welcomeMessage' => $welcomeMessage));
        }
    }

    public function actionUpgradeDB() {
        $migrationInfoPanel = $this->processDatabaseMigration();
        $this->render('_dbUpgradeFinish', array('migrationInfoPanel' => $migrationInfoPanel), false, true);
    }

    private function processDatabaseMigration() {
        $migrationResult = Yii::app()->dbMigrator->runMigrations();
        $migratonLog = reset($migrationResult);
        $migrationStatus = key($migrationResult);

        if ($migrationStatus == DbMigrator::NONE) {
            return array();
        }

        $label = 'Database Migration ';
        if ($migrationStatus == DbMigrator::FAILED) {
            $label.='<span style="color:red">FAILED</span>';
        }
        if ($migrationStatus == DbMigrator::SUCCESS) {
            $label.='<span style="color:green">SUCCESSFULLY</span>';
        }

        return array($label => $migratonLog);
    }

    private function checkDefaultLogin() {

        // check if default user admin/secret is set
        $user = User::model()->findByAttributes(array('username' => 'admin', 'role' => 'admin'));
        if ($user != NULL && $user->validatePassword('secret')) {
            return $this->defaultAdminWarning;
        }

        //check if deafult demo user demo/secret is set
        $user = User::model()->findByAttributes(array('username' => 'demo', 'role' => 'demo'));
        if ($user != NULL && $user->validatePassword('secret')) {
            return $this->defaultDemoWarning;
        }
        return '';
    }

}

?>