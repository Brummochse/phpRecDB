<?php
include_once "../constants.php";
include_once Constants::getFunctionsFolder() . "functions.watermark.php";
include_once Constants::getFunctionsFolder() . 'function.getRelativePathTo.php';
include_once ('../libs/Smarty/Smarty.class.php');
include_once Constants::getClassFolder() . "SettingsManager.php";
include_once Constants::getClassFolder() . "ScreenshotUploader.php";

class ContentPage extends ContentPageSmarty {

    private $fontsFolder = "fonts/";
    private $previewThumbnailFileName = "watermarkpreviewThumb.jpg";
    private $previewFileName = "watermarkpreview.jpg";

    public function getPageTemplateFileName() {
        return "watermark.tpl";
    }

    public function execute($smarty,$linky) {
        $smarty->assign("relativeTemplatesPath", getRelativePathTo(Constants::getTemplateFolder()));

        $settingsManager = new SettingsManager();

        if (isset ($_POST['submitted'])) {
            foreach ($_POST AS $key => $value) {
                $_POST[$key] = mysql_real_escape_string($value);
            }
            $textenable = $_POST['textenabled'];
            $text = $_POST['text'];
            $fontsize = $_POST['fontsize'];
            $textborder = $_POST['textborder'];
            $align = $_POST['align'];
            $valign = $_POST['valign'];
            $fontstyle = $_POST['fontstyle'];
            $red = $_POST['red'];
            $green = $_POST['green'];
            $blue = $_POST['blue'];
            $thumbailenabled = $_POST['thumbailenabled'];
            $resizeenabled = $_POST['resizeenabled'];

            $settingsManager->setPropertyValue(TEXTENABLED, $textenable);
            $settingsManager->setPropertyValue(TEXT, $text);
            $settingsManager->setPropertyValue(FONTSIZE, $fontsize);
            $settingsManager->setPropertyValue(TEXTBORDER, $textborder);
            $settingsManager->setPropertyValue(ALIGN, $align);
            $settingsManager->setPropertyValue(VALIGN, $valign);
            $settingsManager->setPropertyValue(FONTSTYLE, $fontstyle);
            $settingsManager->setPropertyValue(RED, $red);
            $settingsManager->setPropertyValue(GREEN, $green);
            $settingsManager->setPropertyValue(BLUE, $blue);
            $settingsManager->setPropertyValue(THUMBNAIL, $thumbailenabled);
            $settingsManager->setPropertyValue(RESIZETHUMBNAIL, $resizeenabled);

        } else {
            if (!$settingsManager->containsProperty(TEXTENABLED)) {
                $this->setDefaults($settingsManager);
            }
            $textenable = $settingsManager->getPropertyValue(TEXTENABLED);
            $text = $settingsManager->getPropertyValue(TEXT);
            $fontsize = $settingsManager->getPropertyValue(FONTSIZE);
            $textborder = $settingsManager->getPropertyValue(TEXTBORDER);
            $align = $settingsManager->getPropertyValue(ALIGN);
            $valign = $settingsManager->getPropertyValue(VALIGN);
            $fontstyle = $settingsManager->getPropertyValue(FONTSTYLE);
            $red = $settingsManager->getPropertyValue(RED);
            $green = $settingsManager->getPropertyValue(GREEN);
            $blue = $settingsManager->getPropertyValue(BLUE);
            $thumbailenabled = $settingsManager->getPropertyValue(THUMBNAIL);
            $resizeenabled = $settingsManager->getPropertyValue(RESIZETHUMBNAIL);
        }

        $smarty->assign('textenabled', $textenable);
        $smarty->assign('text', $text);
        $smarty->assign('fontsize', $fontsize);
        $smarty->assign('textborder', $textborder);
        $smarty->assign('align', array (
                "left" => "left",
                "center" => "center",
                "right" => "right"
        ));
        $smarty->assign('align_id', $align);
        $smarty->assign('valign', array (
                "top" => "top",
                "middle" => "middle",
                "bottom" => "bottom"
        ));
        $smarty->assign('valign_id', $valign);
        $smarty->assign('fontstyles', $this->getAvailableFonts($this->fontsFolder));
        $smarty->assign('fontstyleSelection', $fontstyle);
        $smarty->assign('red', $red);
        $smarty->assign('green', $green);
        $smarty->assign('blue', $blue);
        $smarty->assign('thumbailenabled', $thumbailenabled);
        $smarty->assign('resizeenabled', $resizeenabled);

        if ($textenable==true) {
            $smarty->assign('previewPicturePath', $this->createSampleScreenshotAndGetPath($textenable,$fontsize,$fontstyle,$textborder,$align,$valign,$text,$red,$green,$blue));
            $smarty->assign('previewThumbnailPath', $this->createSampleThumbnailAndGetPath($textenable,$fontsize,$fontstyle,$textborder,$align,$valign,$text,$red,$green,$blue));
        }
    }

    function createSampleScreenshotAndGetPath($textenable,$fontsize,$fontstyle,$textborder,$align,$valign,$text,$red,$green,$blue) {
        $picture = @ imagecreate(720, 576) or die('Cannot Initialize new GD image stream');
        imagecolorallocate($picture, 0, 0, 0);
        $savePath = Constants::getScreenshotsFolder() . $this->previewFileName;

        if ($textenable == true) {
            $color = ImageColorAllocate($picture, $red, $green, $blue);
            $fontfile = $this->fontsFolder . $fontstyle;

            imagestringbox($picture, $fontsize, $fontfile, $textborder, $align, $valign, $text, $color);
        }
        imagejpeg($picture, $savePath, 70);
        imageDestroy($picture);
        $path=getRelativePathTo(Constants::getScreenshotsFolder()) . $this->previewFileName . "?rnd=" . time();
        return $path;
    }

    function createSampleThumbnailAndGetPath($textenable,$fontsize,$fontstyle,$textborder,$align,$valign,$text,$red,$green,$blue) {

        $picture = @ imagecreate(720, 576) or die('Cannot Initialize new GD image stream');
        imagecolorallocate($picture, 0, 0, 0);
        $savePath = Constants::getScreenshotsFolder() . $this->previewThumbnailFileName;

        $screenshotUploader=new ScreenshotUploader();
        $thumbnailImage=$screenshotUploader->createThumbnail($picture);

        imagejpeg($thumbnailImage, $savePath, 70);
        imageDestroy($picture);
        imageDestroy($thumbnailImage);
        $path=getRelativePathTo(Constants::getScreenshotsFolder()) . $this->previewThumbnailFileName . "?rnd=" . time();
        return $path;
    }

    function setDefaults($settingsManager) {
        $settingsManager->setPropertyValue(TEXTENABLED, 0);
        $settingsManager->setPropertyValue(TEXT, '(C) phpRecDB');
        $settingsManager->setPropertyValue(FONTSIZE, 20);
        $settingsManager->setPropertyValue(TEXTBORDER, 10);
        $settingsManager->setPropertyValue(ALIGN, 'left');
        $settingsManager->setPropertyValue(VALIGN, 'top');
        $settingsManager->setPropertyValue(FONTSTYLE, 'VERDANA.TTF');
        $settingsManager->setPropertyValue(RED, 255);
        $settingsManager->setPropertyValue(GREEN, 0);
        $settingsManager->setPropertyValue(BLUE, 0);
        $settingsManager->setPropertyValue(THUMBNAIL, 1);
        $settingsManager->setPropertyValue(RESIZETHUMBNAIL, 1);
    }

    function getAvailableFonts($fontFolderPath) {
        $fontstyles = array ();
        $dp = opendir($fontFolderPath);
        while ($file = readdir($dp)) {
            $filepath = dirname(__FILE__);
            if (strlen($file) > 3) {
                array_push($fontstyles, $file);
            }
        }
        closedir($dp);
        return $fontstyles;
    }
}
?> 
