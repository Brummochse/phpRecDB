<?php

class ListConfigController extends AdminController {

    public function filters() {
        return array(
            'accessControl',
        );
    }

    public function accessRules() {
        return array(
            array('allow', // allow authenticated users to access all actions
                'roles' => array('admin'),
            ),
            array('deny'),
        );
    }

     public function actionAdmin() {

        $this->render('columns');
    }

}
