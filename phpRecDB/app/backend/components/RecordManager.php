<?php

class RecordManager extends CApplicationComponent {

    public function createNewConcert($addRecordFormModel) {
        $concert = new Concert();
        $concert->fillDataFromConcertFormModel($addRecordFormModel);

        if ($concert->save()) {
            Yii::log("concert added successfully", CLogger::LEVEL_INFO);
            return $concert;
        } else {
            Yii::log("concert adding error", CLogger::LEVEL_ERROR);
            return NULL;
        }
    }

    /**
     * creates a new record model together with a audio or video model
     * 
     * @param type $va  VA::VIDEO or VA::Audio
     * @param type $concertModel a existing concert
     * @return the record-id of the new created record model (or null if any error occurs)
     */
    public function addRecordToConcert($va, $concertModel) {
        $saveResult = false;

        if ($concertModel != NULL) {
            $recordModel = new Record();
            $recordModel->concerts_id = $concertModel->id;
            $saveResult = $recordModel->save();

            if ($va == VA::VIDEO) {
                $newVaModel = new Video();
            } else { //= VA::AUDIO
                $newVaModel = new Audio();
            }
            $newVaModel->recordings_id = $recordModel->id;
            $saveResult = $saveResult && $newVaModel->save();
        }
        if ($saveResult) {
            Yii::log("record added successfully", CLogger::LEVEL_INFO);
            return $recordModel->id;
        } else {
            Yii::log("record adding failed", CLogger::LEVEL_ERROR);
            return NULL;
        }
    }

}

?>
