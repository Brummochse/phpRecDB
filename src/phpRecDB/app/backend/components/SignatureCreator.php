<?php

class SignatureCreator {

    private $image = null;
    private $curY = 0; //current height
    private $curX = 0; //current Width
    private $maxWidth = 0;
    private $signature = null;
    private $fontFile;
    private $fontFileBold;
    private $rowSpace = 2; //in pixels

    public function __construct(Signature $signature) {
        if ($signature != NULL) {
            $this->signature = $signature;

            //set font files
            $this->fontFile = Yii::app()->params['fontFolder'] . DIRECTORY_SEPARATOR . Yii::app()->params['signatureFont'];
            $this->fontFileBold = Yii::app()->params['fontFolder'] . DIRECTORY_SEPARATOR . Yii::app()->params['signatureFontBold'];


            /* begin write test image to check the maximum width , this lines setting the maxWidth variable */
            $this->createEmptyImage(1000);
            $this->printAdditionalText();
            $this->printRecords();
            /* end */

            //this can happens when there are NO shows (=> recordcount = 0)
            if ($this->maxWidth == 0) {
                $this->maxWidth = 400;
            }

            $this->createEmptyImage($this->maxWidth);
            $this->printAdditionalText();
            $this->printRecords();
            $this->addFooter();
        }
    }

    public function saveToFile($path) {
        $signatureImage = $this->getImage();

        if ($signatureImage != null) {
            imagepng($signatureImage, $path, $this->signature->quality);
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
        $this->curY = 0;
        $this->curX = 0;

        $width = $imageWidth;   //Breite des Bildes
        $height = ($this->signature->recordsCount + 1) * ($this->signature->fontSize + $this->rowSpace) + $this->rowSpace + 2;

        $additionalText = $this->signature->additionalText;
        if ($additionalText != null && strlen($additionalText) > 0) {
            $height +=$this->signature->fontSize + $this->rowSpace;
        }

        $this->image = imagecreatetruecolor($width, $height);
        $bgColor = $this->getBcColor();
        ImageFilledRectangle($this->image, 0, 0, $width, $height, $bgColor);
    }

    private function incrementRow() {
        $this->curY +=$this->signature->fontSize + $this->rowSpace;
    }

    private function printRecords() {
        $newsRecordModels = $this->signature->getRecords();
        $i = 0;
        foreach ($newsRecordModels as $recordModel) {
            $i++;
            if ($this->signature->recordsCount < $i)
                return;
            $artist = $recordModel->concert->artist->name;
            $date = $recordModel->concert->date;

            $country = $recordModel->concert->country != null ? $recordModel->concert->country->name : "";
            $city = $recordModel->concert->city != null ? $recordModel->concert->city->name : "";
            $venue = $recordModel->concert->venue != null ? $recordModel->concert->venue->name : "";

            $supplement = $recordModel->concert->supplement;
            $sourceidentification = $recordModel->sourceidentification;
            $created = $recordModel->created;
            //video=0, audio=1

            if ($recordModel->video != NULL) {
                $videoOrAudio = VA::vaIdToStr(VA::VIDEO);
            } else if ($recordModel->audio != NULL) {
                $videoOrAudio = VA::vaIdToStr(VA::AUDIO);
            } else {
                $videoOrAudio = VA::vaIdToStr(VA::UNDEFINED);
            }

            $placeInfo = $country . " " . $city . " " . $venue . " " . $supplement;
            $this->addARecord($created, $videoOrAudio, $artist, $date, $placeInfo, $sourceidentification);
        }
    }

    private function addARecord($created, $videoOrAudio, $artist, $date, $placeInfo, $sourceidentification) {
        $this->incrementRow();
        $this->addCreatedInfo($created);
        $this->addVideoOrAudioInfo($videoOrAudio);
        $this->addArtistInfo($artist);
        $this->addDateInfo($date);
        $this->addPlaceInfo($placeInfo);
        $this->addSourceIdentificationInfo($sourceidentification);

        $this->curX = 0;
    }

    /**
     * for a mystery reason on servers the utf8 imagettftext does not work.
     * this encodes th string to some scary stuff which is printabel as utf8
     * 
     * stolen form here:
     * http://stackoverflow.com/questions/198007/php-function-imagettftext-and-unicode
     * 
     * @param type $text
     * @return type
     */
    private function ensureUtf8Text($text) {
        # detect if the string was passed in as unicode
        $text_encoding = mb_detect_encoding($text, 'UTF-8, ISO-8859-1');
        # make sure it's in unicode
        if ($text_encoding != 'UTF-8') {
            $text = mb_convert_encoding($text, 'UTF-8', $text_encoding);
        }

        # html numerically-escape everything (&#[dec];)
        $text = mb_encode_numericentity($text, array(0x0, 0xffff, 0, 0xffff), 'UTF-8');
        return $text;
    }
    
    private function printText($text, $fontType, $color, $space = 0) {
        $text=$this->ensureUtf8Text($text);

        $this->curX +=$space;

        $textAngle = 0;
        $dimension = imagettftext($this->image, $this->signature->fontSize, $textAngle, $this->curX, $this->curY, $color, $fontType, $text);
        $dimensionLeft = $dimension[0];
        $dimensionRight = $dimension[2];
        $width = $dimensionRight - $dimensionLeft;

        $this->curX +=$width;

        if ($this->curX > $this->maxWidth) {
            $this->maxWidth = $this->curX;
        }
    }

    private function printAdditionalText() {
        $additionalText = $this->signature->additionalText;
        if ($additionalText != null && strlen($additionalText) > 0) {

            $color = $this->getColor1();

            $this->incrementRow();
            $this->printText($additionalText, $this->fontFileBold, $color, 3);
            $this->curX = 0;
        }
    }

    private function addFooter() {
        $text = "www.phpRecDB.com";

        $color = $this->getColor1();

        $this->incrementRow();
        $text2 = "created by phpRecDB " . Yii::app()->params['version'];
        $this->printText($text2, $this->fontFileBold, $color, 3);

        $textDimension = imagettfbbox($this->signature->fontSize, 0, $this->fontFileBold, $text);
        $dimensionLeft = $textDimension[0];
        $dimensionRight = $textDimension[2];
        $textWidth = $dimensionRight - $dimensionLeft;

        imagettftext($this->image, $this->signature->fontSize, 0, $this->maxWidth - $textWidth, $this->curY, $color, $this->fontFileBold, $text);
    }

    private function addCreatedInfo($created) {
        $text = "added " . substr($created, 0, 10);
        $color = $this->getColor3();
        $this->printText($text, $this->fontFile, $color, 0);
    }

    private function addSourceIdentificationInfo($sourceidentification) {
        $text = "";
        if ($sourceidentification != null && strlen($sourceidentification) > 0) {
            $text = "(" . $sourceidentification . ")";
        }

        $color = $this->getColor1();
        $this->printText($text, $this->fontFile, $color, 5);
    }

    private function addPlaceInfo($placeInfo) {
        $color = $this->getColor3();
        $this->printText($placeInfo, $this->fontFile, $color, 5);
    }

    private function addDateInfo($date) {
        $color = $this->getColor1();
        $this->printText($date, $this->fontFileBold, $color, 5);
    }

    private function addArtistInfo($artist) {
        $color = $this->getColor2();
        $this->printText($artist, $this->fontFileBold, $color, 5);
    }

    private function addVideoOrAudioInfo($videoOrAudio) {
        $color = $this->getColor1();
        $this->printText($videoOrAudio, $this->fontFile, $color, 10);
    }

    //////////////////////////////
    ////////COLORS////////////////
    //////////////////////////////

    private function allocateColorFromHex($handle, $hex) {
        if (strlen($hex) == 4)
            $hex = '#' . $hex[1] . $hex[1] . $hex[2] . $hex[2] . $hex[3] . $hex[3];

        $red = hexdec(substr($hex, 1, 2));
        $green = hexdec(substr($hex, 3, 2));
        $blue = hexdec(substr($hex, 5, 2));

        return ImageColorAllocate($handle, $red, $green, $blue);
    }

    private function getBcColor() {
        if ($this->signature->bgTransparent == true) {
            imagealphablending($this->image, FALSE);
            imagesavealpha($this->image, TRUE);
            return imagecolorallocatealpha($this->image, 255, 0, 0, 125);
        } else {
            return $this->allocateColorFromHex($this->image, $this->signature->bgColor);
        }
    }

    private function getColor1() {
        return $this->allocateColorFromHex($this->image, $this->signature->color1);
    }

    private function getColor2() {
        return $this->allocateColorFromHex($this->image, $this->signature->color2);
    }

    private function getColor3() {
        return $this->allocateColorFromHex($this->image, $this->signature->color3);
    }

}

?>
