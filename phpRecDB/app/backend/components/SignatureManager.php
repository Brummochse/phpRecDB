<?php

class SignatureManager extends CApplicationComponent {

    const ALLSIGS_DIR = "sigs";
    const SIG_FILENAME = 'sig.png';

    private function getSigFolderPath($signatureName) {
        $sigDir = $signatureName . '.png';

        return Yii::app()->params['miscPath'] . DIRECTORY_SEPARATOR .
                self::ALLSIGS_DIR . DIRECTORY_SEPARATOR .
                $sigDir;
    }

    /**
     * checks if currectly changed record is contained in a enabled signature => if true, update all signature
     * 
     * @param type $changedRecordId
     */
    public function updateSignaturesIfRequired($changedRecordId) {

        $signatureModels = Signature::model()->findAll();
        //
        if (count($signatureModels) == 0) {
            return;
        }

        //search enabled signature with needs the most records
        $selSignature = NULL;
        $maxRecords = -1;
        foreach ($signatureModels as $signatureModel) {
            if ($signatureModel->enabled == true &&  $signatureModel->recordsCount > $maxRecords) {
                $maxRecords = $signatureModel->recordsCount;
                $selSignature = $signatureModel;
            }
        }

        //
        if ($selSignature != NULL && $selSignature->signatureContainsRecord($changedRecordId)) {
            $this->updateSignatures($signatureModels);
        }
    }

    public function updateSignatures($signatureModels=NULL) {
        if ($signatureModels==NULL) {
            $signatureModels = Signature::model()->findAll();
        }
        
        foreach ($signatureModels as $signatureModel) {
            $this->generateSignature($signatureModel);
        }
    }

    public function deleteSignature(Signature $signatureModel) {
        $sigFolder = $this->getSigFolderPath($signatureModel->name);
        if (file_exists($sigFolder)) {
            Helper::removeDir($sigFolder);
        }

        $signatureModel->delete();
    }

    public function generateSignature($signatureModel) {

        $sigFolder = $this->getSigFolderPath($signatureModel->name);
        $sigFileName = 'sig.' . 'png';

        //create new
        if ($signatureModel->enabled) {

            if (!file_exists($sigFolder)) {
                mkdir($sigFolder, 0777, true);
            }
            //create static signature img
            $sigCreator = new SignatureCreator($signatureModel);
            $sigCreator->saveToFile($sigFolder . DIRECTORY_SEPARATOR . $sigFileName);

            // create index.php for dynamic signature creation
            $destination = $sigFolder . DIRECTORY_SEPARATOR . 'index.php';
            if (!file_exists($destination)) {
                $source = Yii::app()->getBasePath() . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'dynamicSignatur.php';
                copy($source, $destination);
            }
        } else {
            //cleanup old
            if (file_exists($sigFolder)) {
                Helper::removeDir($sigFolder);
            }
        }
    }

}

?>
