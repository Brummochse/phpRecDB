<?php

class WebUser extends CWebUser {

    public $authExpires; // let authentication expire if user is inactive for this number of seconds

    const admin = "admin";
    const user = "user";
    const demo = "demo";

    public function isAdmin() {
        $role = $this->getState("roles");
        return $role === self::admin;
    }

    public function isUser() {
        $role = $this->getState("roles");
        return $role === self::user;
    }

    public function isDemo() {
        $role = $this->getState("roles");
        return $role === self::demo;
    }

    /**
     * Overrides a Yii method that is used for roles in controllers (accessRules).
     *
     * @param string $operation Name of the operation required (here, a role).
     * @param mixed $params (opt) Parameters for this operation, usually the object to access.
     * @return bool Permission granted?
     */
    function checkAccess($operation,$params=array(),$allowCaching=true) {
        if (empty($this->id)) {
            // Not identified => no rights
            return false;
        }
        $role = $this->getState("roles");
        if ($role === 'admin') {
            return true; // admin role has access to everything
        }
        // allow access if the operation request is the current user's role
        return ($operation === $role);
    }

    /**
     *  stolen from: http://www.yiiframework.com/forum/index.php/topic/13733-standard-yii-logout-timeout/
     * 
     * makes sure that user gets auto logout after expire time
     */
    public function getIsGuest() {
        $isGuest = $this->getState('__id') === null;
        $expires = $this->getState('__expires');

        if (!$isGuest && $this->authExpires !== null) {
            if ($expires !== null && $expires < time()) {  // authentication expired
                // TBD:
                //   - Either always (true) or never (false) destroys session data! Not what everyone wants...
                //   - Make sure __expires is also cleared from session in logout()
                $this->logout();
                $isGuest = true;
            } else {                    // update expiration timestamp
                $this->setState('__expires', time() + $this->authExpires);
            }
        }
        return $isGuest;
    }

    const ERROR = "ERROR";
    const INFO = "INFO";
    const SUCCESS = "SUCCESS";
    
    private $flashMsgCounters=array();
    
    public function addMsg($msgType,$msg)
    {
        if (!array_key_exists($msgType, $this->flashMsgCounters)) {
            $this->flashMsgCounters[$msgType]=0;
        }
        $this->flashMsgCounters[$msgType] ++;
        
        $this->setFlash($msgType.$this->flashMsgCounters[$msgType],$msg);
    }


}

?>