<?php

class LastDaysNewsListDataConfig extends ListDataConfig {

    public function __construct($daysCount = 5, $isAdminCall = false) {
        parent::__construct($isAdminCall);

        $sqlQuery = 'SELECT DISTINCT date(recordings.created) AS creationDate' .
                ' FROM concerts' .
                ' LEFT OUTER JOIN recordings ON concerts.id = recordings.concerts_id' .
                //INNER JOIN video ON video.recordings_id = recordings.id
                ' WHERE visible = true' .
                ' ORDER BY creationDate DESC LIMIT 0, ' . $daysCount;
        $lastDates = Yii::app()->db->createCommand($sqlQuery)->queryColumn();
        if ($lastDates != NULL && count($lastDates) > 0) {
            $oldestDate = $lastDates[count($lastDates) - 1];

            $this->isArtistMenuVisible = false;

            $this->additionalRecordListCols[""] = array("created");
            $this->recordListFilters[] = "created>='" . $oldestDate . "'";

            $this->defaultOrder = 'Date(created) DESC, VideoType DESC,AudioType DESC, Artist, misc';
        }
    }

}
?>
