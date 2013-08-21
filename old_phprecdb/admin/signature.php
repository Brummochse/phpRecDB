<?php
include_once dirname(__FILE__) . "/../classes/SignatureSettings.php";
include_once dirname(__FILE__) . "/../constants.php";
include_once Constants::getFunctionsFolder() . 'function.getRelativePathTo.php';
include_once ('../libs/Smarty/Smarty.class.php');
include_once Constants::getClassFolder()."SignatureCreator.php";

class ContentPage extends ContentPageSmarty {

    public function getPageTemplateFileName() {
        return "signature.tpl";
    }

    public function execute($smarty,$linky) {
        $smarty->assign("relativeTemplatesPath", getRelativePathTo(Constants::getTemplateFolder()));

        $sigConfig=new SignatureSettings();

        if (isset ($_POST['submitted'])) {
            foreach ($_POST AS $key => $value) {
                $_POST[$key] = mysql_real_escape_string($value);
            }
            foreach($sigConfig->getKeys() as $key) {
                $sigConfig->setValue($key,$_POST[$key]);
            }
            $sigConfig->save();
        } else {
            $sigConfig->load();
        }
        //set smarty varaibles
        foreach($sigConfig->getKeys() as $key) {
            $smarty->assign($key, $sigConfig->getValue($key));
        }

        if ($sigConfig->getValue(SIGNATURE_ENABLED)==true) {
            $smarty->assign('signaturePicturePath', $this->createSignatureAndGetPath($sigConfig));
            $smarty->assign('signatureImagePath',$this->getSigImageHttpPath());
            $smarty->assign('dynamicSignaturePath',$this->getDynamicSigHttpPath());
        }

    }

    private function getSigImageHttpPath() {
        $currentDir=dirname(dirname($_SERVER['SCRIPT_NAME']));
        $signatueFilePath=$currentDir.Constants::getSignatureFileName();
        return (isset($_SERVER['HTTPS'])?'https':'http').'://' . $_SERVER['HTTP_HOST'] .$signatueFilePath  ;
    }

    private function getDynamicSigHttpPath() {
        $currentDir=dirname(dirname($_SERVER['SCRIPT_NAME']));
        $signatueFilePath=$currentDir.Constants::getDynamicSignatureName();
        return (isset($_SERVER['HTTPS'])?'https':'http').'://' . $_SERVER['HTTP_HOST'] .$signatueFilePath  ;
    }

    private function createSignatureAndGetPath($signatureSettings) {
        SignatureCreator::updateSignature();
        $path=getRelativePathTo(Constants::getRootFolder()) . Constants::getSignatureFileName() . "?rnd=" . time();
        return $path;
    }



}
?>
