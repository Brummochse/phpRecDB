<?php

class SignatureCreator {

    private $fontHeight = 11;
    private $image = null;
    private $currentHeigth = 0;
    private $currentWidth = 0;
    private $maxWidth = 0;
    private $signature = null;

    public function __construct(Signature $signature) {
        if ($signature != NULL) {
            $this->signature = $signature;

            /* begin write test image to check the maximum widh , this lines setting the maxWidth variable */
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
            $this->addBanner();
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
        $this->currentHeigth = 0;
        $this->currentWidth = 0;

        $width = $imageWidth;   //Breite des Bildes
        $height = ($this->signature->recordsCount + 1) * $this->fontHeight + 2;

        $additionalText = $this->signature->additionalText;
        if ($additionalText != null && strlen($additionalText) > 0) {
            $height +=$this->fontHeight;
        }

        $this->image = imagecreatetruecolor($width, $height);
        $bgColor = $this->getBcColor();
        ImageFilledRectangle($this->image, 0, 0, $width, $height, $bgColor);
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
            } else  if ($recordModel->audio != NULL) {
                $videoOrAudio = VA::vaIdToStr(VA::AUDIO);
            } else {
                $videoOrAudio = VA::vaIdToStr(VA::UNDEFINED);
            }

            $placeInfo = $country . " " . $city . " " . $venue . " " . $supplement;

            $this->addARecord($created, $videoOrAudio, $artist, $date, $placeInfo, $sourceidentification);
        }
    }

    private function addARecord($created, $videoOrAudio, $artist, $date, $placeInfo, $sourceidentification) {
        $this->addCreatedInfo($created);
        $this->addVideoOrAudioInfo($videoOrAudio);
        $this->addArtistInfo($artist);
        $this->addDateInfo($date);
        $this->addPlaceInfo($placeInfo);
        $this->addSourceIdentificationInfo($sourceidentification);

        $this->currentHeigth +=$this->fontHeight;
        $this->currentWidth = 0;
    }

    private function printText($text, $font, $color, $space = 0) {
        $text_width = imagefontwidth($font);
        $width = $text_width * strlen($text);
        $this->currentWidth +=$space;
        ImageString($this->image, $font, $this->currentWidth, $this->currentHeigth, $text, $color);
        $this->currentWidth +=$width;

        if ($this->currentWidth > $this->maxWidth) {
            $this->maxWidth = $this->currentWidth;
        }
    }

    private function printAdditionalText() {
        $additionalText = $this->signature->additionalText;
        if ($additionalText != null && strlen($additionalText) > 0) {
            $font = 3;

            $color = $this->getColor1();

            $this->printText($additionalText, $font, $color, 0);
            $this->currentHeigth +=$this->fontHeight;
            $this->currentWidth = 0;
        }
    }

    private function addBanner() {
        $text = "www.phpRecDB.de.vu";

        $font = 3;

        $text_width = imagefontwidth($font);
        $width = $text_width * strlen($text);

        $color = $this->getColor1();

        $text2 = "created by phpRecDB " . Yii::app()->params['version'];
        $this->printText($text2, $font, $color, 0);
        ImageString($this->image, $font, $this->maxWidth - $width, $this->currentHeigth, $text, $color);
    }

    private function addCreatedInfo($created) {
        $text = "added " . substr($created, 0, 10);
        $font = 2;
        $color = $this->getColor3();
        $this->printText($text, $font, $color, 0);
    }

    private function addSourceIdentificationInfo($sourceidentification) {
        $text = "";
        if ($sourceidentification != null && strlen($sourceidentification) > 0) {
            $text = "(" . $sourceidentification . ")";
        }

        $font = 2;
        $color = $this->getColor1();
        $this->printText($text, $font, $color, 5);
    }

    private function addPlaceInfo($placeInfo) {
        $font = 3;
        $color = $this->getColor3();
        $this->printText($placeInfo, $font, $color, 5);
    }

    private function addDateInfo($date) {
        $font = 3;
        $color = $this->getColor1();
        $this->printText($date, $font, $color, 5);
    }

    private function addArtistInfo($artist) {
        $font = 3;
        $color = $this->getColor2();
        $this->printText($artist, $font, $color, 5);
    }

    private function addVideoOrAudioInfo($videoOrAudio) {
        $font = 2;
        $color = $this->getColor1();
        $this->printText($videoOrAudio, $font, $color, 10);
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
