<?php

class AdminController extends CController {

    public $layout = 'admin';
    private $flashMsgs = null; 
    
    public function getMenuItems() {
        return AdminMenuItems::getInstance()->createAdminMenuItems();
    }
    
    public function getFlashesArray($msgType) {
        if ($this->flashMsgs==null) {
            $this->flashMsgs = Yii::app()->user->getFlashes();
        }
        $results=array();
        
        foreach($this->flashMsgs as $key => $message) {
            if (Helper::startsWith($key, $msgType)) {
                $results[]=$message;
            }
        }
        return $results;        
    }
  
    private function generateNotificationBlock($msgs,$label,$cssClass) {
        $notBlockHtml = '';

        foreach ($msgs as $key => $msg) {
            $notBlockHtml .= '<div class="alert in alert-block fade '.$cssClass.'"><strong>'.$label.'</strong><br />' .  $msg . '</div>';
        }
        return $notBlockHtml;
    }

    public function getNotificationsHtml() {
        $logsHtml = '';
        
        $logsHtml.=$this->generateNotificationBlock($this->getFlashesArray(WebUser::ERROR),WebUser::ERROR,'alert-error');
        $logsHtml.=$this->generateNotificationBlock($this->getFlashesArray(WebUser::INFO),WebUser::INFO,'alert-warning');
        $logsHtml.=$this->generateNotificationBlock($this->getFlashesArray(WebUser::SUCCESS),WebUser::SUCCESS,'alert-success');
        
        echo $logsHtml;
    }
    
    public function hasAutoOpenMessages()
    {
        return count($this->getFlashesArray(WebUser::ERROR))>0 || count($this->getFlashesArray(WebUser::SUCCESS))>0;
    }

    public function getNotificationMenuItems() {
        $menuItems = array();

        $flashMsgsSuccess =$this->getFlashesArray(WebUser::SUCCESS);
        $flashMsgsInfo = $this->getFlashesArray(WebUser::INFO);
        $flashMsgsError = $this->getFlashesArray(WebUser::ERROR);

        if (count($flashMsgsError) > 0) {
            $menuItems[] = array('icon' => 'fire white', 'label' => count($flashMsgsError), 'url' => '#');
        }
        if (count($flashMsgsSuccess) > 0) {
            $menuItems[] = array('icon' => 'ok  white', 'label' => count($flashMsgsSuccess), 'url' => '#');
        }
        if (count($flashMsgsInfo) > 0) {
            $menuItems[] = array('icon' => 'envelope white', 'label' => count($flashMsgsInfo), 'url' => '#');
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