<?php

class AdminController extends CController {

    public $layout = 'admin';
    
    private $notificationLevelCss = array(
        CLogger::LEVEL_ERROR => array('alert-error', 'ERROR'),
        CLogger::LEVEL_WARNING => array('alert-warning', 'WARNING'),
        CLogger::LEVEL_INFO => array('alert-success', 'SUCCESS')
    );

    /**
     * @var array the breadcrumbs of the current page. The value of this property will
     * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
     * for more details on how to specify this property.
     */
    // public $breadcrumbs = array();

    public function init() {
        parent::init();
    }

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

}