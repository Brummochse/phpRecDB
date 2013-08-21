<?php

include_once dirname(__FILE__) . "/../constants.php";
include_once dirname(__FILE__) . "/../classes/SignatureSettings.php";
include_once Constants::getClassFolder()."NewsListData.php";

class SignatureCreator {

    private $fontHeight=11;

    private $image=null;

    private $currentHeigth=0;
    private $currentWidth=0;
    private $maxWidth=0;

    private $sigConfig=null;

    public static function updateSignature() {
        $sigConfig=new SignatureSettings();
        $sigConfig->load();
        $signatureCreator=new SignatureCreator($sigConfig);
        $savePath = Constants::getRootFolder() . Constants::getSignatureFileName();
        $signatureCreator->saveToFile($savePath);
    }

    public function __construct($sigConfig) {
        if ($sigConfig->getValue(SIGNATURE_ENABLED)==true) {
            $this->sigConfig=$sigConfig;

            $this->createEmptyImage(1000);
            $this->printAdditionalText();
            $this->printRecords();

            $this->createEmptyImage($this->maxWidth);
            $this->printAdditionalText();
            $this->printRecords();
            $this->addBanner();
        }
    }

    public function saveToFile($path) {
        $signatureImage=$this->getImage();

        if ($signatureImage!=null) {
            imagepng($signatureImage, $path, $this->sigConfig->getValue(QUALITY));
            imageDestroy($signatureImage);
        } else {
            if (file_exists($path)) {
                unlink($path);
            }
        }
    }

    public function getImage() {
        return $this->image;
    }

    private function createEmptyImage($imageWidth) {
        $this->currentHeigth=0;
        $this->currentWidth=0;

        $width = $imageWidth;   //Breite des Bildes
        $height = ($this->sigConfig->getValue(RECORDS_COUNT)+1)*$this->fontHeight+2;

        $additionalText=$this->sigConfig->getValue(ADDITIONAL_TEXT);
        if ($additionalText != null && strlen($additionalText)>0) {
            $height +=$this->fontHeight;
        }

        $this->image=imagecreatetruecolor($width,$height);
        $bgColor=$this->getBcColor();
        ImageFilledRectangle($this->image, 0, 0, $width, $height, $bgColor);

    }

    private function printRecords() {
        $newsListData = new NewsListData(VIDEO_AND_AUDIO, $this->sigConfig->getValue(RECORDS_COUNT), LAST_RECORDS);
        $concertsSql = $newsListData->getRecords();

        while ($concert = mysql_fetch_row($concertsSql)) {
            foreach ($concert AS $key => $value) {
                $concert[$key] = stripslashes($value);
            }

            $artist = $concert[1];
            $date = $concert[2];
            $country = $concert[3];
            $city = $concert[4];
            $venue = $concert[5];
            $supplement = $concert[6];
            $sourceidentification = $concert[14];
            $created = $concert[18];
            //video=0, audio=1
            $videoOrAudio = $concert[19];
            $placeInfo= $country." ".$city." ".$venue." ".$supplement;

            $this->addARecord($created,$videoOrAudio,$artist,$date,$placeInfo,$sourceidentification);
        }
    }

    private function addARecord($created,$videoOrAudio,$artist,$date,$placeInfo,$sourceidentification) {
        $this->addCreatedInfo($created);
        $this->addVideoOrAudioInfo($videoOrAudio);
        $this->addArtistInfo($artist);
        $this->addDateInfo($date);
        $this->addPlaceInfo($placeInfo);
        $this->addSourceIdentificationInfo($sourceidentification);

        $this->currentHeigth +=$this->fontHeight;
        $this->currentWidth=0;
    }

    private function printText($text,$font,$color,$space=0) {
        $text_width = imagefontwidth($font);
        $width = $text_width * strlen($text);
        $this->currentWidth +=$space;
        ImageString($this->image, $font, $this->currentWidth, $this->currentHeigth, $text, $color);
        $this->currentWidth +=$width;

        if ($this->currentWidth > $this->maxWidth) {
            $this->maxWidth=$this->currentWidth;
        }
    }

    private function printAdditionalText() {
        $additionalText=$this->sigConfig->getValue(ADDITIONAL_TEXT);
        if ($additionalText != null && strlen($additionalText)>0) {
            $font = 3;

            $color=$this->getColor1();

            $this->printText($additionalText,$font,$color,0);
            $this->currentHeigth +=$this->fontHeight;
            $this->currentWidth=0;
        }
    }

    private function addBanner() {
        $text="www.phpRecDB.de.vu";

        $font = 3;

        $text_width = imagefontwidth($font);
        $width = $text_width * strlen($text);

        $color=$this->getColor1();

        $text2="created by phpRecDB ".Constants::getScriptVersion();
        $this->printText($text2,$font,$color,0);
        ImageString($this->image, $font, $this->maxWidth-$width,$this->currentHeigth, $text, $color);
    }

    private function addCreatedInfo($created) {
        $text="added ".substr($created,0,10);
        $font = 2;
        $color=$this->getColor3();
        $this->printText($text,$font,$color,0);
    }

    private function addSourceIdentificationInfo($sourceidentification) {
        $text="";
        if ($sourceidentification!=null && strlen($sourceidentification)>0) {
            $text="(".$sourceidentification.")";
        }

        $font = 2;
        $color=$this->getColor1();
        $this->printText($text,$font,$color,5);
    }

    private function addPlaceInfo($placeInfo) {
        $font = 3;
        $color=$this->getColor3();
        $this->printText($placeInfo,$font,$color,5);
    }

    private function addDateInfo($date) {
        $font = 3;
        $color=$this->getColor1();
        $this->printText($date,$font,$color,5);
    }

    private function addArtistInfo($artist) {
        $font = 3;
        $color=$this->getColor2();
        $this->printText($artist,$font,$color,5);
    }

    private function addVideoOrAudioInfo($videoOrAudio) {
        if ($videoOrAudio==0) {
            $text="Video:";
        } else {
            $text="Audio:";
        }

        $font = 2;
        $color=$this->getColor1();
        $this->printText($text,$font,$color,10);
    }

    //////////////////////////////
    ////////COLORS////////////////
    //////////////////////////////

    private function getBcColor() {
        if ($this->sigConfig->getValue(BG_TRANSPARENT)==true) {
            imagealphablending($this->image, FALSE);
            imagesavealpha($this->image, TRUE);
            return imagecolorallocatealpha($this->image,  255, 0, 0, 125);
        } else {
            return ImageColorAllocate($this->image,
                    $this->sigConfig->getValue(BG_COLOR_RED),
                    $this->sigConfig->getValue(BG_COLOR_GREEN),
                    $this->sigConfig->getValue(BG_COLOR_BLUE));
        }

    }
    private function getColor1() {
        return ImageColorAllocate($this->image,
                $this->sigConfig->getValue(COLOR1_RED),
                $this->sigConfig->getValue(COLOR1_GREEN),
                $this->sigConfig->getValue(COLOR1_BLUE));
    }
    private function getColor2() {
        return ImageColorAllocate($this->image,
                $this->sigConfig->getValue(COLOR2_RED),
                $this->sigConfig->getValue(COLOR2_GREEN),
                $this->sigConfig->getValue(COLOR2_BLUE));
    }
    private function getColor3() {
        return ImageColorAllocate($this->image,
                $this->sigConfig->getValue(COLOR3_RED),
                $this->sigConfig->getValue(COLOR3_GREEN),
                $this->sigConfig->getValue(COLOR3_BLUE));
    }

}
?>
