<?php
include_once dirname(__FILE__) . "/../constants.php";
include_once Constants :: getSettingsFolder() . "dbConnection.php";
include_once Constants :: getLibsFolder() . 'Smarty/Smarty.class.php';
include_once Constants :: getFunctionsFolder() . 'function.getRelativePathTo.php';

class NavigationBar {

    private $placeHolderDivId="phpRecDbNavBarPlaceHolder";
    private $jsNeeded=false;
    private $cssPrinted=false;
    private $recordId=null;
    private $listData=null;
    private static $instance = NULL;

    public static function getInstance() {
        if (self :: $instance === NULL) {
            self :: $instance = new self;
        }
        return self :: $instance;
    }

    public function setListData($listData) {
        $this->listData=$listData;
    }

    public function isJsNeeded() {
        return $this->jsNeeded;
    }

    public function setRecordId($recordId) {
        $this->recordId = $recordId;
    }

    private function getBandNameById($bandId) {
        $sqlQuery = "SELECT name FROM artists " .
                " WHERE id='$bandId'";
        $result = mysql_query($sqlQuery);

        if (!$result) {
            //TODO Fehlerbehandung, fehler beim auslesen der Property
        }
        $row = mysql_fetch_assoc($result);
        $bandName = $row['name'];
        return $bandName;
    }

    private function getRecordInfoTextById($recordId) {
        include_once Constants :: getFunctionsFolder() . 'function.getConcertInfo.php';
        $recInfo=getConcertInfoAsArray($recordId);
        $text=$recInfo['artist']." ".$recInfo['date'];
        return $text;
    }

    private function printCss() {
        if ($this->cssPrinted == false) {
            $relativeTemplatesPath= getRelativePathTo(Constants :: getTemplateFolder());
            echo "<link rel='stylesheet' type='text/css' href='".$relativeTemplatesPath."navBar.css'>";
            $this->cssPrinted = true;
        }
    }

    public function printNavBar() {
        $this->printCss();
        if ($this->listData == null ) {
            $this->printNavBarPlaceHolder();
        } else {
            echo $this->getNavBarHtml();
        }
    }

    public function printNavBarPlaceHolder() {
        $this->jsNeeded=true;
        echo "<div id='".$this->placeHolderDivId."' /> </div>";
    }

    public function printNavBarJS() {
        echo $this->getNavBarJS();
    }

    private function getNavBarJS() {
        $navBarHtml=$this->getNavBarHtml();

        $pattern = "/\r|\n/s";
        $replacement = " ";
        $navBarHtml = preg_replace($pattern, $replacement, $navBarHtml);

        $navBarJS= "<script type='text/javascript'>".
                "function hallo() {".
                "output=\"".$navBarHtml."\";".
                "document.getElementById('".$this->placeHolderDivId."').innerHTML = output;".
                "}".
                "hallo();".
                "</script>";
        return $navBarJS;
    }

    private  function createNavBarElement($link,$caption) {
        $navBarElement= array ('link'=>$link,
                'caption'=>$caption);
        return $navBarElement;
    }

    public function getNavBarHtml() {
        dbConnect();

        $listName=$this->listData->getListName();
        $artistId=$this->listData->getArtistId();
        $year=$this->listData-> getSelectedYear();


        $navBarElements=array();
        if ($listName !=null) {
            $link=$this->createLink(null,null,null);
            $navBarElements[]=$this->createNavBarElement($link, $listName);
        }
        if ($artistId !=null) {
            $link=$this->createLink($artistId,null,null);
            $artistName=$this->getBandNameById($artistId);
            $navBarElements[]=$this->createNavBarElement($link, $artistName);
        }
        if ($year !=null) {
            $link=$this->createLink($artistId,$year,null);
            $navBarElements[]=$this->createNavBarElement($link, $year);
        }

        if ($this->recordId !=null) {
            $link=$this->createLink($artistId,$year,$this->recordId);
            $recordInfoText=$this->getRecordInfoTextById($this->recordId);
            $navBarElements[]=$this->createNavBarElement($link,$recordInfoText );
        }

        $smarty = new Smarty;
        $smarty->template_dir = Constants :: getTemplateFolder();
        $smarty->compile_dir = Constants :: getCompileFolder();

        $smarty->assign('navBarElements',$navBarElements);

        ob_start();
        $smarty->display(Constants :: getTemplateFolder() . "navbar.tpl");
        $content = ob_get_contents();
        ob_end_clean();
        return $content;
    }

    private function createLink($artistId,$year,$recordId) {
        $params=array (Constants::getParamArtistId()=>$artistId,
                Constants::getParamYear()=>$year,
                Constants::getParamRecordId()=>$recordId);
        return  Helper::makeUrl($params);
    }
}
?>
