<?php

class ListDataConfigurator extends CApplicationComponent {

    public function isDefaultActionDefined() {
        return isset(Yii::app()->params['defaultAction']);
    }

    public function evalListDataConfig() {

        if (isset(Yii::app()->params['defaultAction'])) {
            $action = Yii::app()->params['defaultAction'];

            switch ($action) {
                case ListActionMap::RECORDS:
                    return $this->evalRecordsConfig();
                case ListActionMap::RECORDS_Video:
                    return $this->evalRecordsConfig(VA::VIDEO);
                case ListActionMap::RECORDS_Audio:
                    return $this->evalRecordsConfig(VA::AUDIO);
                case ListActionMap::NEWS:
                    return $this->evalNewsConfig();
                case ListActionMap::NEWS_Video:
                    return $this->evalNewsConfig(VA::VIDEO);
                case ListActionMap::NEWS_Audio:
                    return $this->evalNewsConfig(VA::AUDIO);
                case ListActionMap::ARTIST:
                    return $this->evalArtistConfig();
                case ListActionMap::SUBLIST:
                    return $this->evalSublistConfig();
            }
        }
        return NULL;
    }

    private function evalNewsConfig($va = VA::VIDEO_AND_AUDIO) {
        $newsCount = Yii::app()->params['newsCount'];
        $newsType = Yii::app()->params['newsType'];

        if ($newsType == LAST_DAYS) {
            $listDataConfig = new LastDaysNewsListDataConfig($newsCount);
        } else { // ==LAST_RECORDS
            $listDataConfig = new LastRecordsNewsListDataConfig($newsCount);
        }
        $listDataConfig->setVideoAudioSelection($va);
        return $listDataConfig;
    }

    private function evalRecordsConfig($va = VA::VIDEO_AND_AUDIO) {
        $collapsed = Yii::app()->params['collapsed'];
        $listDataConfig = new AllListDataConfig($collapsed);
        $listDataConfig->setVideoAudioSelection($va);
        return $listDataConfig;
    }

    private function evalArtistConfig() {
        $artistName = Yii::app()->params['artistName'];

        $artistModel = Artist::model()->findByAttributes(array('name' => $artistName));
        if ($artistModel == NULL) {
            echo "ERROR: artist " . $artistName . " not found";
            return NULL;
        } else {
            return new RecordsForArtistDataConfig($artistModel->id);
        }
    }

    private function evalSublistConfig() {
        $sublistName = Yii::app()->params['sublistName'];
        $collapsed = Yii::app()->params['collapsed'];

        $sublistModel = Sublist::model()->findByAttributes(array('label' => $sublistName));
        if ($sublistModel == NULL) {
            echo "ERROR: sublist " . $sublistName . " not found";
            return NULL;
        } else {
            return new SublistListDataConfig($sublistModel->id, $collapsed);
        }
    }

}

?>
