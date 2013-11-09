<?php

class LastDaysNewsListDataConfig extends ListDataConfig {

    public function __construct($daysCount = 5, $isAdminCall = false) {
        parent::__construct($isAdminCall);

        $lastDates = $this->getLastDatesWhenShowsWereAdded($daysCount);

        if ($lastDates != NULL && count($lastDates) > 0) {
            $oldestDate = $lastDates[count($lastDates) - 1];

            $this->isArtistMenuVisible = false;

            $this->additionalRecordListCols[""] = "created";
            $this->recordListFilters[] = "created>='" . $oldestDate . "'";

            $this->defaultOrder = array('Date' => '(created)',
                'VideoType' => 'DESC',
                'AudioType' => 'DESC',
                'Artist' => 'ASC',
                'Date' => 'ASC',
            );
        }
    }

    /**
     * 
     * @param int $daysCount how many days are searched?
     * @return array with dates when shows were added
     */
    private function getLastDatesWhenShowsWereAdded($daysCount) {
        $sqlQuery = 'SELECT DISTINCT date(recordings.created) AS creationDate' .
                ' FROM concerts' .
                ' LEFT OUTER JOIN recordings ON concerts.id = recordings.concerts_id' .
                //INNER JOIN video ON video.recordings_id = recordings.id
                ' WHERE visible = true' .
                ' ORDER BY creationDate DESC LIMIT 0, ' . $daysCount;
        $lastDates = Yii::app()->db->createCommand($sqlQuery)->queryColumn();
        return $lastDates;
    }

}

?>
