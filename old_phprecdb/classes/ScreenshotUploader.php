<?php
include_once dirname(__FILE__) . "/../constants.php";
include_once Constants :: getFunctionsFolder() . "functions.watermark.php";
include_once Constants :: getClassFolder() . "SettingsManager.php";
include_once Constants :: getClassFolder() . "ScreenshotsManager.php";

class ScreenshotUploader {

    private $settingsManager = null;
    private $newImagefilename;
    private $newThumbnailFilename;


    public function ScreenshotUploader() {
        $this->settingsManager =new SettingsManager();
    }

    public function getNewImagefilename() {
        return $this->newImagefilename;
    }

    public function getNewThumbnailFilename() {
        return $this->newThumbnailFilename;
    }

    public function uploadFile($filename,$recordingId) {
        $upload_image = $this->uploadImage($filename,$recordingId);
        if (is_array($upload_image)) {
            foreach ($upload_image as $key => $value) {
                if ($value == "-ERROR-") {
                    unset ($upload_image[$key]);
                }
            }
            $document = array_values($upload_image);
            for ($x = 0; $x < sizeof($document); $x++) {
                $errorList[] = $document[$x];
            }
            $uploadSuccesfully = false;
        } else {
            $uploadSuccesfully = true;
        }

        if ($uploadSuccesfully) {
            $msg= "upload successful!";
        } else {
            $msg= 'Error(s) Found: ';
            foreach ($errorList as $value) {
                $msg=$msg.$value . ', ';
            }
        }
        $stateMsgHandler= StateMsgHandler::getInstance();
        $stateMsgHandler->addStateMsg($msg);
                   
        return $uploadSuccesfully;
    }

    private function isWatermark() {
        return $this->settingsManager->getPropertyValue(TEXTENABLED);
    }
    private function isWatermarkThumbnail() {
        return $this->settingsManager->getPropertyValue(THUMBNAIL);
    }
    private function isWatermarkResize() {
        return $this->settingsManager->getPropertyValue(RESIZETHUMBNAIL);
    }

    private function watermark(& $image) {
        global $settingsManager;
        if ($this->isWatermark()) {
            $textenable = $this->settingsManager->getPropertyValue(TEXTENABLED);
            $text = $this->settingsManager->getPropertyValue(TEXT);
            $fontsize = $this->settingsManager->getPropertyValue(FONTSIZE);
            $textborder = $this->settingsManager->getPropertyValue(TEXTBORDER);
            $align = $this->settingsManager->getPropertyValue(ALIGN);
            $valign = $this->settingsManager->getPropertyValue(VALIGN);
            $fontstyle = $this->settingsManager->getPropertyValue(FONTSTYLE);
            $red = $this->settingsManager->getPropertyValue(RED);
            $green = $this->settingsManager->getPropertyValue(GREEN);
            $blue = $this->settingsManager->getPropertyValue(BLUE);
            $color = ImageColorAllocate($image, $red, $green, $blue);
            $fontfile = "fonts/" . $fontstyle;
            imagestringbox($image, $fontsize, $fontfile, $textborder, $align, $valign, $text, $color);
        }
    }

    private function saveImage($image, $filetype, $folder, $imagefilename, & $errorList) {
        $newImagefilename=$imagefilename.".".$filetype;
        $imageSavePath=$folder.$newImagefilename;

        switch ($filetype) {
            case "gif" :
                if (!@ imagegif($image, $imageSavePath)) {
                    $errorList[] = "PERMISSION DENIED [GIF]";
                }
                break;
            case "jpg" :
                if (!@ imagejpeg($image, $imageSavePath, 70)) {
                    $errorList[] = "PERMISSION DENIED [JPG]";
                }
                break;
            case "jpeg" :
                if (!@ imagejpeg($image, $imageSavePath, 70)) {
                    $errorList[] = "PERMISSION DENIED [JPEG]";
                }
                break;
            case "png" :
                if (!@ imagepng($image, $imageSavePath, 0)) {
                    $errorList[] = "PERMISSION DENIED [PNG]";
                }
                break;
            case "bmp" :
                if (!@ $this->imagebmp($image, $imageSavePath)) {
                    $errorList[] = "PERMISSION DENIED [BMP]";
                }
                break;
            default:
                throw new Exception('unknown filetype');
        }
        return $newImagefilename;
    }

    private function loadImage($filetype, $filePath) {
        switch ($filetype) {
            case "gif" :
                $image = @ imagecreatefromgif($filePath);
                break;
            case "jpg" :
                $image = @ imagecreatefromjpeg($filePath);
                break;
            case "jpeg" :
                $image = @ imagecreatefromjpeg($filePath);
                break;
            case "png" :
                $image = @ imagecreatefrompng($filePath);
                break;
            case "bmp" :
                $image = @ $this->imagecreatefrombmp($filePath);
                break;
            default:
                throw new Exception('unknown filetype');
        }
        return $image;
    }

    public function createThumbnail($image) {
        $maxW = Constants :: getThumbnaiWith();
        $width_orig = imagesx($image);
        $height_orig = imagesy($image);

        if ($width_orig < $maxW) {
            $fwidth = $width_orig;
        } else {
            $fwidth = $maxW;
        }
        $ratio_orig = $width_orig / $height_orig;
        $fheight = $fwidth / $ratio_orig;

        $top_offset = 0;
        $image_p = imagecreatetruecolor($fwidth, $fheight);
        $white = imagecolorallocate($image_p, 255, 255, 255);
        imagefill($image_p, 0, 0, $white);

        if ($this->isWatermark() && $this->isWatermarkThumbnail() && $this->isWatermarkResize()) {
            $this->watermark($image);
        }
        @ imagecopyresampled($image_p, $image, 0, $top_offset, 0, 0, $fwidth, $fheight, $width_orig, $height_orig);
        if ($this->isWatermark() && $this->isWatermarkThumbnail() && !$this->isWatermarkResize()) {
            $this->watermark($image_p);
        }
        return $image_p;

    }

    private function uploadImage($fileName,$recordingId) {
        $maxSize = 99999999999;
        $fullPath = '../screenshots/';

        $errorList=array();
        
        $folder = $fullPath;
        $maxlimit = $maxSize;
        $allowed_ext = "jpg,jpeg,gif,png,bmp";
        $match = "";
        $filesize = $_FILES[$fileName]['size'];
        if ($filesize > 0) {
            $filename = strtolower($_FILES[$fileName]['name']);
            $filename = preg_replace('/\s/', '_', $filename);
            if ($filesize < 1) {
                $errorList[] = "File size is empty.";
            }
            if ($filesize > $maxlimit) {
                $errorList[] = "File size is too big.";
            }
            if (count($errorList) < 1) {
                $file_ext = preg_split("/\./", $filename);
                $allowed_ext = preg_split("/\,/", $allowed_ext);
                foreach ($allowed_ext as $ext) {
                    if ($ext == end($file_ext)) {
                        $match = "1"; // File is allowed
                        $NUM = time();

                        //////////filename
                        $front_name=ScreenshotsManager::getScreenshotName($recordingId);

                        $newImagefilename = $front_name . "_" . $NUM;
                        $newThumbnailFilename = "thumb_" . $newImagefilename;
                        $oldFiletype = end($file_ext);

                        $isJpgCompr = $this->settingsManager->getPropertyValue('screenshot_compression');
                        if ($isJpgCompr) {
                            $newFiletype='jpg';
                        } else {
                            $newFiletype=$oldFiletype;
                        }

                        $image = $this->loadImage($oldFiletype, $_FILES[$fileName]['tmp_name']);
                        $imageThumbnail = $this->createThumbnail($image);

                        $newThumbnailFilename=$this->saveImage($imageThumbnail, $newFiletype,$folder, $newThumbnailFilename, $errorList);

                        if ($this->isWatermark()) {
                            if (!$this->isWatermarkThumbnail() || !$this->isWatermarkResize()) {
                                $this->watermark($image);
                            }
                        }
                        $newImagefilename=$this->saveImage($image, $newFiletype,$folder, $newImagefilename, $errorList);

                        imageDestroy($image);
                        @ imagedestroy($filename);

                    }
                }
            }
        } else {
            $errorList[] = "NO FILE SELECTED";
        }
        if (!$match) {
            $errorList[] = "File type isn't allowed: $filename";
        }

        $this->newImagefilename=$newImagefilename;
        $this->newThumbnailFilename=$newThumbnailFilename;

        if (sizeof($errorList) == 0) {
            return "succes";
        } else {
            $eMessage = array ();
            for ($x = 0; $x < sizeof($errorList); $x++) {
                $eMessage[] = $errorList[$x];
            }
            return $eMessage;
        }
    }

    function imagebmp($im, $filename='', $bit=24, $compression=0) {
        // version 1.00
        if (!in_array($bit, array(1, 4, 8, 16, 24, 32))) {
            $bit = 24;
        }
        else if ($bit == 32) {
            $bit = 24;
        }
        $bits = pow(2, $bit);
        imagetruecolortopalette($im, true, $bits);
        $width = imagesx($im);
        $height = imagesy($im);
        $colors_num = imagecolorstotal($im);
        $rgb_quad = '';
        if ($bit <= 8) {
            for ($i = 0; $i < $colors_num; $i++) {
                $colors = imagecolorsforindex($im, $i);
                $rgb_quad .= chr($colors['blue']) . chr($colors['green']) . chr($colors['red']) . "\0";
            }
            $bmp_data = '';
            if ($compression == 0 || $bit < 8) {
                $compression = 0;
                $extra = '';
                $padding = 4 - ceil($width / (8 / $bit)) % 4;
                if ($padding % 4 != 0) {
                    $extra = str_repeat("\0", $padding);
                }
                for ($j = $height - 1; $j >= 0; $j --) {
                    $i = 0;
                    while ($i < $width) {
                        $bin = 0;
                        $limit = $width - $i < 8 / $bit ? (8 / $bit - $width + $i) * $bit : 0;
                        for ($k = 8 - $bit; $k >= $limit; $k -= $bit) {
                            $index = imagecolorat($im, $i, $j);
                            $bin |= $index << $k;
                            $i++;
                        }
                        $bmp_data .= chr($bin);
                    }
                    $bmp_data .= $extra;
                }
            }
            // RLE8
            else if ($compression == 1 && $bit == 8) {
                for ($j = $height - 1; $j >= 0; $j--) {
                    $last_index = "\0";
                    $same_num = 0;
                    for ($i = 0; $i <= $width; $i++) {
                        $index = imagecolorat($im, $i, $j);
                        if ($index !== $last_index || $same_num > 255) {
                            if ($same_num != 0) {
                                $bmp_data .= chr($same_num) . chr($last_index);
                            }
                            $last_index = $index;
                            $same_num = 1;
                        }
                        else {
                            $same_num++;
                        }
                    }
                    $bmp_data .= "\0\0";
                }
                $bmp_data .= "\0\1";
            }
            $size_quad = strlen($rgb_quad);
            $size_data = strlen($bmp_data);
        }
        else {
            $extra = '';
            $padding = 4 - ($width * ($bit / 8)) % 4;
            if ($padding % 4 != 0) {
                $extra = str_repeat("\0", $padding);
            }
            $bmp_data = '';
            for ($j = $height - 1; $j >= 0; $j--) {
                for ($i = 0; $i < $width; $i++) {
                    $index  = imagecolorat($im, $i, $j);
                    $colors = imagecolorsforindex($im, $index);
                    if ($bit == 16) {
                        $bin = 0 << $bit;
                        $bin |= ($colors['red'] >> 3) << 10;
                        $bin |= ($colors['green'] >> 3) << 5;
                        $bin |= $colors['blue'] >> 3;
                        $bmp_data .= pack("v", $bin);
                    }
                    else {
                        $bmp_data .= pack("c*", $colors['blue'], $colors['green'], $colors['red']);
                    }
                }
                $bmp_data .= $extra;
            }
            $size_quad = 0;
            $size_data = strlen($bmp_data);
            $colors_num = 0;
        }
        $file_header = 'BM' . pack('V3', 54 + $size_quad + $size_data, 0, 54 + $size_quad);
        $info_header = pack('V3v2V*', 0x28, $width, $height, 1, $bit, $compression, $size_data, 0, 0, $colors_num, 0);
        if ($filename != '') {
            $fp = fopen($filename, 'wb');
            fwrite($fp, $file_header . $info_header . $rgb_quad . $bmp_data);
            fclose($fp);
            return true;
        }
        echo $file_header . $info_header. $rgb_quad . $bmp_data;
        return true;
    }

    function imagecreatefrombmp($filename) {
        // version 1.00
        if (!($fh = fopen($filename, 'rb'))) {
            trigger_error('imagecreatefrombmp: Can not open ' . $filename, E_USER_WARNING);
            return false;
        }
        // read file header
        $meta = unpack('vtype/Vfilesize/Vreserved/Voffset', fread($fh, 14));
        // check for bitmap
        if ($meta['type'] != 19778) {
            trigger_error('imagecreatefrombmp: ' . $filename . ' is not a bitmap!', E_USER_WARNING);
            return false;
        }
        // read image header
        $meta += unpack('Vheadersize/Vwidth/Vheight/vplanes/vbits/Vcompression/Vimagesize/Vxres/Vyres/Vcolors/Vimportant', fread($fh, 40));
        // read additional 16bit header
        if ($meta['bits'] == 16) {
            $meta += unpack('VrMask/VgMask/VbMask', fread($fh, 12));
        }
        // set bytes and padding
        $meta['bytes'] = $meta['bits'] / 8;
        $meta['decal'] = 4 - (4 * (($meta['width'] * $meta['bytes'] / 4)- floor($meta['width'] * $meta['bytes'] / 4)));
        if ($meta['decal'] == 4) {
            $meta['decal'] = 0;
        }
        // obtain imagesize
        if ($meta['imagesize'] < 1) {
            $meta['imagesize'] = $meta['filesize'] - $meta['offset'];
            // in rare cases filesize is equal to offset so we need to read physical size
            if ($meta['imagesize'] < 1) {
                $meta['imagesize'] = @filesize($filename) - $meta['offset'];
                if ($meta['imagesize'] < 1) {
                    trigger_error('imagecreatefrombmp: Can not obtain filesize of ' . $filename . '!', E_USER_WARNING);
                    return false;
                }
            }
        }
        // calculate colors
        $meta['colors'] = !$meta['colors'] ? pow(2, $meta['bits']) : $meta['colors'];
        // read color palette
        $palette = array();
        if ($meta['bits'] < 16) {
            $palette = unpack('l' . $meta['colors'], fread($fh, $meta['colors'] * 4));
            // in rare cases the color value is signed
            if ($palette[1] < 0) {
                foreach ($palette as $i => $color) {
                    $palette[$i] = $color + 16777216;
                }
            }
        }
        // create gd image
        $im = imagecreatetruecolor($meta['width'], $meta['height']);
        $data = fread($fh, $meta['imagesize']);
        $p = 0;
        $vide = chr(0);
        $y = $meta['height'] - 1;
        $error = 'imagecreatefrombmp: ' . $filename . ' has not enough data!';
        // loop through the image data beginning with the lower left corner
        while ($y >= 0) {
            $x = 0;
            while ($x < $meta['width']) {
                switch ($meta['bits']) {
                    case 32:
                    case 24:
                        if (!($part = substr($data, $p, 3))) {
                            trigger_error($error, E_USER_WARNING);
                            return $im;
                        }
                        $color = unpack('V', $part . $vide);
                        break;
                    case 16:
                        if (!($part = substr($data, $p, 2))) {
                            trigger_error($error, E_USER_WARNING);
                            return $im;
                        }
                        $color = unpack('v', $part);
                        $color[1] = (($color[1] & 0xf800) >> 8) * 65536 + (($color[1] & 0x07e0) >> 3) * 256 + (($color[1] & 0x001f) << 3);
                        break;
                    case 8:
                        $color = unpack('n', $vide . substr($data, $p, 1));
                        $color[1] = $palette[ $color[1] + 1 ];
                        break;
                    case 4:
                        $color = unpack('n', $vide . substr($data, floor($p), 1));
                        $color[1] = ($p * 2) % 2 == 0 ? $color[1] >> 4 : $color[1] & 0x0F;
                        $color[1] = $palette[ $color[1] + 1 ];
                        break;
                    case 1:
                        $color = unpack('n', $vide . substr($data, floor($p), 1));
                        switch (($p * 8) % 8) {
                            case 0:
                                $color[1] = $color[1] >> 7;
                                break;
                            case 1:
                                $color[1] = ($color[1] & 0x40) >> 6;
                                break;
                            case 2:
                                $color[1] = ($color[1] & 0x20) >> 5;
                                break;
                            case 3:
                                $color[1] = ($color[1] & 0x10) >> 4;
                                break;
                            case 4:
                                $color[1] = ($color[1] & 0x8) >> 3;
                                break;
                            case 5:
                                $color[1] = ($color[1] & 0x4) >> 2;
                                break;
                            case 6:
                                $color[1] = ($color[1] & 0x2) >> 1;
                                break;
                            case 7:
                                $color[1] = ($color[1] & 0x1);
                                break;
                        }
                        $color[1] = $palette[ $color[1] + 1 ];
                        break;
                    default:
                        trigger_error('imagecreatefrombmp: ' . $filename . ' has ' . $meta['bits'] . ' bits and this is not supported!', E_USER_WARNING);
                        return false;
                }
                imagesetpixel($im, $x, $y, $color[1]);
                $x++;
                $p += $meta['bytes'];
            }
            $y--;
            $p += $meta['decal'];
        }
        fclose($fh);
        return $im;
    }
}
?>