<?php

class AdminController extends CController {

    public $layout = 'admin';
    
    private $notificationLevelCss = array(
        CLogger::LEVEL_ERROR => array('alert-error', 'ERROR'),
        CLogger::LEVEL_WARNING => array('alert-warning', 'WARNING'),
        CLogger::LEVEL_INFO => array('alert-success', 'SUCCESS')
    );

    public function getMenuItems() {
        return AdminMenuItems::getInstance()->createAdminMenuItems();
    }
    
    private function generateNotificationBlock($log) {
        $logMsg = $log[0];
        $logLevel = $log[1];

        $notBlockHtml = '';

        if (isset($this->notificationLevelCss[$logLevel])) {
            $cssClass = $this->notificationLevelCss[$logLevel][0];
            $label = $this->notificationLevelCss[$logLevel][1];

            $notBlockHtml = '<div class="alert in alert-block fade '.$cssClass.'"><strong>'.$label.'</strong><br />' .  $logMsg . '</div>';
        }
        return $notBlockHtml;
    }

    public function getNotificationsHtml() {
        $logsHtml = '';
        foreach (Yii::getLogger()->getLogs() as $log) {
            $logsHtml.=$this->generateNotificationBlock($log);
        }
        echo $logsHtml;
    }

    public function getNotificationMenuItems() {
        $menuItems = array();

        $logsInfo = Yii::getLogger()->getLogs('info');
        $logsWarning = Yii::getLogger()->getLogs('warning');
        $logsError = Yii::getLogger()->getLogs('error');

        if (count($logsError) > 0) {
            $menuItems[] = array('icon' => 'fire white', 'label' => count($logsError), 'url' => '#');
        }
        if (count($logsWarning) > 0) {
            $menuItems[] = array('icon' => 'warning-sign white', 'label' => count($logsWarning), 'url' => '#');
        }
        if (count($logsInfo) > 0) {
            $menuItems[] = array('icon' => 'envelope white', 'label' => count($logsInfo), 'url' => '#');
        }

        return $menuItems;
    }
    
    // access rules for all children classes
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

}