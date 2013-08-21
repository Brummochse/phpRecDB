<?php

class Linky {

    private $paramName;
    //index=>link
    private $decryptList = array();
    //link=>index
    private $encryptList = array();
    //link=>name
    private $linkList = array();
    private $sites;
    private $counter = 0;
    private $parameters = array();
    private $selectedId;

    public function Linky($paramName='') {
        include_once dirname(__FILE__) . "/../constants.php";
        include_once Constants :: getClassFolder() . "Helper.php";
        include Constants::getAdminFolder() . "sitemap.php";
        $this->paramName = $paramName;
        $this->sites = $sites;
        $this->createCryptLists();
        $this->selectedId = Helper::getParamAsInt(Constants::getParamAdminMenuIndex());
    }

    private function createCryptLists() {
        foreach ($this->sites as $key => $value) {
            $this->counter++;
            $this->decryptList[$this->counter] = $key;
            $this->encryptList[$key] = $this->counter;
            $this->linkList[$key] = $value;
        }
    }

    private function createLink($id, $params) {
        $paramStr = '';
        if (is_array($params)) {
            foreach ($params as $paramName => $paramValue) {
                $paramStr = $paramStr . "&" . $paramName . "=" . $paramValue;
            }
        }
        return "?" . $this->paramName . "=" . $id . $paramStr;
    }

    public function getParameters($link) {
        return $this->parameters[$link];
    }

    public function addParameter($link, $parameter) {
        $this->parameters[$link] = $parameter;
    }

    public function encryptName($name, $params=null) {
        $id = $this->encryptList[$name];
        return $this->createLink($id, $params);
    }

    public function decryptLink() {
        if (empty($this->selectedId)) {
            return null;
        }
        return $this->sites[$this->decryptList[$this->selectedId]];
    }

    public function decryptName() {
        return $this->decryptList[$this->selectedId];
    }

}

?>
