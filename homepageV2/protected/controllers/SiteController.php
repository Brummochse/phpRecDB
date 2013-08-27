<?php

class SiteController extends CController {

    public function actions() {
        return array(
            'page' => array(
                'class' => 'CViewAction',
            ),
        );
    }

    public function actionIndex() {
        $this->render("pages/home");
    }

}

?>
