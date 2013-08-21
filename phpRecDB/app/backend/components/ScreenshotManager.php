<?php

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

    public function watermarkThumbnail(WatermarkForm $watermarkModel, $sourceImgFile, $destThumbnailPath) {
        if ($watermarkModel->watermarkThumbnail) {
            $thumbnailImage = new SimpleImage($sourceImgFile);
                            
            if (!$watermarkModel->resizeOnThumbnail) {
                $thumbnailImage->fit_to_width(Yii::app()->params['thumbnailWidth']);
            }

            $this->watermark($watermarkModel, $thumbnailImage);

            if ($watermarkModel->resizeOnThumbnail) {
                $thumbnailImage->fit_to_width(Yii::app()->params['thumbnailWidth']);
            }
            //save thumbnail
            try {
                $thumbnailImage->save($destThumbnailPath);
            } catch (Exception $e) {
                Yii::log("error saving watermarked thumbnail:" . $e->getMessage(), CLogger::LEVEL_ERROR);
                return false;
            }
        }
        return true;
    }

    public function watermarkScreenshot(WatermarkForm $watermarkModel, $sourceImgFile, $destScreenshotPath) {
        if ($watermarkModel->enable) {

            $image = new SimpleImage($sourceImgFile);

            $this->watermark($watermarkModel, $image);

            //save screenshot
            try {
                $image->save($destScreenshotPath);
            } catch (Exception $e) {
                Yii::log("error saving watermarked screenshot:" . $e->getMessage(), CLogger::LEVEL_ERROR);
                return false;
            }
        }
        return true;
    }

    private function saveScreenshot(CUploadedFile $screenshotFile, $newScreenshotlabel, WatermarkForm $watermarkModel) {
        $newScreenshotFileName = $newScreenshotlabel . '.' . strtolower($screenshotFile->extensionName);
        $newScreenshotFilePath = Yii::app()->params['screenshotsPath'] . DIRECTORY_SEPARATOR . $newScreenshotFileName;

        $saveSuccess = false;
        if ($watermarkModel->enable) {
            $saveSuccess = $this->watermarkScreenshot($watermarkModel, $screenshotFile->getTempName(), $newScreenshotFilePath);
        } else {
            //saving screenshots is possible without image processing, so do not use simpleimage
            $saveSuccess = $screenshotFile->saveAs($newScreenshotFilePath);
        }
        return $saveSuccess ? $newScreenshotFileName : NULL;
    }

    private function saveThumbnail(CUploadedFile $screenshotFile, $newScreenshotlabel, WatermarkForm $watermarkModel) {
        $newThumbnailFileName = 'thumb_' . $newScreenshotlabel . '.' . strtolower($screenshotFile->extensionName);
        $newThumbnailFilePath = Yii::app()->params['screenshotsPath'] . DIRECTORY_SEPARATOR . $newThumbnailFileName;

        $saveSuccess = false;
        if ($watermarkModel->enable && $watermarkModel->watermarkThumbnail) {
            $saveSuccess = $this->watermarkThumbnail($watermarkModel, $screenshotFile->getTempName(), $newThumbnailFilePath);
        } else {
            //save without watermark
            $thumbnailImage = new SimpleImage($screenshotFile->getTempName());
            $thumbnailImage->fit_to_width(Yii::app()->params['thumbnailWidth']);
            try {
                $saveSuccess = $thumbnailImage->save($newThumbnailFilePath);
            } catch (Exception $e) {
                Yii::log("error saving thumbnail:" . $e->getMessage(), CLogger::LEVEL_ERROR);
                $saveSuccess = false;
            }
        }
        return $saveSuccess ? $newThumbnailFileName : NULL;
    }

    /**
     * 
     * @param type $screenshotFiles array of CUploadedFile
     * @param type $recordId
     */
    public function proccessUploadedScreenshots($screenshotFiles, $recordId) {

        if (isset($screenshotFiles) && count($screenshotFiles) > 0) {

            $watermarkModel = WatermarkForm::createFromSettingsDb();
            $screenshotCounter = 0;
            foreach ($screenshotFiles as $key =>  $screenshotFile) {

                $screenshotCounter++;
                
                //check if uplaod was seuccessfull, erros can happen when fielsize is bigger than max uplaod size
                $screenshotTempname=$screenshotFile->getTempName();
                if (empty($screenshotTempname) || $screenshotFile->getSize()==0) {
                    Yii::log('file upload failed: '.$screenshotFile->getName(), CLogger::LEVEL_ERROR);
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
                        Yii::log("error writing screenshot", CLogger::LEVEL_ERROR);
                    }
                } else {

                    Yii::log("error writing thumbnail", CLogger::LEVEL_ERROR);
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
                Yii::log("error deleting image file (deletion failed): " . $filePath, CLogger::LEVEL_ERROR);
            }
        } else {
            Yii::log("error deleting image file (does not exist): " . $filePath, CLogger::LEVEL_ERROR);
        }
    }

}

?>
