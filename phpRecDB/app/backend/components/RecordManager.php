<?php

class RecordManager extends CApplicationComponent {

    public function createNewConcert($addRecordFormModel) {
        $concert = new Concert();
        $concert->fillDataFromConcertFormModel($addRecordFormModel);

        if ($concert->save()) {
             Yii::app()->user->addMsg(WebUser::INFO, "concert added successfully");
            return $concert;
        } else {
            Yii::app()->user->addMsg(WebUser::ERROR, "concert adding error");
            return NULL;
        }
    }

    /**
     * creates a new record model together with a audio or video model
     * 
     * @param type $va  VA::VIDEO or VA::Audio
     * @param type $visible  true or false
     * @param type $concertModel a existing concert
     * @return the record-id of the new created record model (or null if any error occurs)
     */
    public function addRecordToConcert($va,$visible, $concertModel) {
        $saveResult = false;

        if ($concertModel != NULL) {
            $recordModel = new Record();
            $recordModel->visible=$visible;
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
            Yii::app()->user->addMsg(WebUser::INFO, "record added successfully");
            return $recordModel->id;
        } else {
            Yii::app()->user->addMsg(WebUser::ERROR, "record adding failed");
            return NULL;
        }
    }

}

?>
