<?php

class ImgSource {

    public $sourceUploadedFile = null; //CUploadedFile
    public $sourceSimpleImage = null; //SimpleImage    

    public static function createFromCUploadedFile($sourceUploadedFile) {
        $newImgSource = new ImgSource();
        $newImgSource->sourceUploadedFile = $sourceUploadedFile;
        return $newImgSource;
    }

    public static function createFromSimpleImage($sourceSimpleImage) {
        $newImgSource = new ImgSource();
        $newImgSource->sourceSimpleImage = $sourceSimpleImage;
        return $newImgSource;
    }

}

class ScreenshotManager extends CApplicationComponent {

    /**
     * @return installed fonts for watermarking
     */
    public function getFonts() {
        $fontFolderPath = Yii::app()->params['fontFolder'];
        return Helper::getFilesFromFolder($fontFolderPath);
    }

    private function watermark(WatermarkForm $watermarkModel, SimpleImage $image) {
        return $image->text(
                        $watermarkModel->text, Yii::app()->params['fontFolder'] . '/' . $watermarkModel->fontStyle, $watermarkModel->fontSize, $watermarkModel->color, $watermarkModel->getSimpleImagePosition(), $watermarkModel->calcSimpleImageXOffset(), $watermarkModel->calcSimpleImageYOffset()
        );
    }

    /**
     * 1. screenshot save plain
     * 2. screenshot save compressed
     * 3. screenshot save watermark
     * 4. screenshot save watermark compressed
     * 5. thumbnail save plain 
     * 6. thumbnail save compressed
     * 7. thumbnail save watermark
     * 8. thumbnail save watermark compressed
     * 
     * returns the filename of the saved image or NULL when some error occured
     */
    public function doSaveImage(ImgSource $source, FileInfo $destFileInfo) {
        $screenComprModel = new ScreenshotCompressionForm();
        $newFileName = "";
        $result = NULL;

        if ($screenComprModel->enable_compression) {

            if ($source->sourceUploadedFile != NULL) { //2.
                $source->sourceSimpleImage = new SimpleImage($source->sourceUploadedFile->getTempName());
            }
            $newFileName = $destFileInfo->fileNameBase . '.jpg';
            $result = $source->sourceSimpleImage->save($destFileInfo->dir . $newFileName, 70); //2. 4. 6. 8.
        } else { //no compression
            $newFileName = $destFileInfo->fileNameBase . '.' . $destFileInfo->fileExtension;
            if ($source->sourceUploadedFile != NULL) { //1.
                $result = $source->sourceUploadedFile->saveAs($destFileInfo->dir . $newFileName); //1.
            } else {
                $result = $source->sourceSimpleImage->save($destFileInfo->dir . $newFileName); //3. 5. 7.
            }
        }
        return $result != NULL && $result != FALSE ? $newFileName : NULL;
    }

    public function watermarkThumbnail(WatermarkForm $watermarkModel, $sourceImgPath, FileInfo $destThumbnailFileInfo) {
        $thumbnailImage = new SimpleImage($sourceImgPath);

        if (!$watermarkModel->resizeOnThumbnail) {
            $thumbnailImage->fit_to_width(Yii::app()->params['thumbnailWidth']);
        }

        $this->watermark($watermarkModel, $thumbnailImage);

        if ($watermarkModel->resizeOnThumbnail) {
            $thumbnailImage->fit_to_width(Yii::app()->params['thumbnailWidth']);
        }
        //save thumbnail
        try {
            return $this->doSaveImage(ImgSource::createFromSimpleImage($thumbnailImage), $destThumbnailFileInfo);
        } catch (Exception $e) {
            Yii::app()->user->addMsg(WebUser::ERROR, "error saving watermarked thumbnail:" . $e->getMessage());
            return NULL;
        }
    }

    public function watermarkScreenshot(WatermarkForm $watermarkModel, $sourceImgFile, FileInfo $destScreenshotFileInfo) {
        $image = new SimpleImage($sourceImgFile);

        $this->watermark($watermarkModel, $image);

        //save screenshot
        try {
            return $this->doSaveImage(ImgSource::createFromSimpleImage($image), $destScreenshotFileInfo);
        } catch (Exception $e) {
            Yii::app()->user->addMsg(WebUser::ERROR, "error saving watermarked screenshot:" . $e->getMessage());
            return NULL;
        }
    }

    private function saveScreenshot(CUploadedFile $screenshotFile, $newScreenshotlabel, WatermarkForm $watermarkModel) {

        $destFileInfo = new FileInfo();
        $destFileInfo->dir =Yii::app()->params['screenshotsPath'] . DIRECTORY_SEPARATOR;
        $destFileInfo->fileNameBase = $newScreenshotlabel;
        $destFileInfo->fileExtension = strtolower($screenshotFile->extensionName);
        
        if ($watermarkModel->enable) {
            return $this->watermarkScreenshot($watermarkModel, $screenshotFile->getTempName(), $destFileInfo);
        } else {
            //saving screenshots is possible without image processing, so do not use simpleimage
            return $this->doSaveImage(ImgSource::createFromCUploadedFile($screenshotFile), $destFileInfo);
        }
    }

    private function saveThumbnail(CUploadedFile $screenshotFile, $newScreenshotlabel, WatermarkForm $watermarkModel) {

        $destFileInfo = new FileInfo();
        $destFileInfo->dir = Yii::app()->params['screenshotsPath'] . DIRECTORY_SEPARATOR;
        $destFileInfo->fileNameBase = 'thumb_' . $newScreenshotlabel;
        $destFileInfo->fileExtension = strtolower($screenshotFile->extensionName);

        if ($watermarkModel->enable && $watermarkModel->watermarkThumbnail) {
            return $this->watermarkThumbnail($watermarkModel, $screenshotFile->getTempName(), $destFileInfo);
        } else {
            //save without watermark
            $thumbnailImage = new SimpleImage($screenshotFile->getTempName());
            $thumbnailImage->fit_to_width(Yii::app()->params['thumbnailWidth']);
            try {
                return $this->doSaveImage(ImgSource::createFromSimpleImage($thumbnailImage), $destFileInfo);
            } catch (Exception $e) {
                Yii::app()->user->addMsg(WebUser::ERROR, "error saving thumbnail:" . $e->getMessage());
                return NULL;
            }
        }
    }

    /**
     * 
     * @param type $screenshotFiles array of CUploadedFile
     * @param type $recordId
     */
    public function proccessUploadedScreenshots($screenshotFiles, $recordId) {

        if (isset($screenshotFiles) && count($screenshotFiles) > 0) {

            $watermarkModel = new WatermarkForm();
            $screenshotCounter = 0;
            foreach ($screenshotFiles as $key => $screenshotFile) {

                $screenshotCounter++;

                //check if uplaod was seuccessfull, erros can happen when fielsize is bigger than max uplaod size
                $screenshotTempname = $screenshotFile->getTempName();
                if (empty($screenshotTempname) || $screenshotFile->getSize() == 0) {
                    Yii::app()->user->addMsg(WebUser::ERROR, 'file upload failed: ' . $screenshotFile->getName());
                    continue;
                }

                //
                $newScreenshotlabel = Screenshot::model()->generateScreenshotName($recordId) . $screenshotCounter;

                if (($thumbnailFileName = $this->saveThumbnail($screenshotFile, $newScreenshotlabel, $watermarkModel)) != NULL) {
                    if (($newScreenshotName = $this->saveScreenshot($screenshotFile, $newScreenshotlabel, $watermarkModel)) != NULL) {
                        $newScreenshot = new Screenshot();
                        $newScreenshot->video_recordings_id = $recordId;
                        $newScreenshot->screenshot_filename = $newScreenshotName;
                        $newScreenshot->thumbnail = $thumbnailFileName;
                        $newScreenshot->order_id = Screenshot::model()->getOrderIdForNewScreenshot($recordId);

                        $newScreenshot->save();
                    } else {
                        Yii::app()->user->addMsg(WebUser::ERROR, "error writing screenshot");
                    }
                } else {
                    Yii::app()->user->addMsg(WebUser::ERROR, "error writing thumbnail");
                }
            }
        }
    }

    public function deleteScreenshot($screenshotModel) {
        $this->deleteFromScreenshotFolder($screenshotModel->screenshot_filename);
        $this->deleteFromScreenshotFolder($screenshotModel->thumbnail);
    }

    private function deleteFromScreenshotFolder($fileName) {
        $filePath = Yii::app()->params['screenshotsPath'] . DIRECTORY_SEPARATOR . $fileName;

        if (file_exists($filePath)) {
            if (!unlink($filePath)) {
                Yii::app()->user->addMsg(WebUser::ERROR, 'error deleting image file (deletion failed): ' . $filePath);
            }
        } else {
            Yii::app()->user->addMsg(WebUser::ERROR, 'error deleting image file (does not exist): ' . $filePath);
        }
    }

}

?>
