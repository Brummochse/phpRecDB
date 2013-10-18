<?php


class LastRecordsNewsListDataConfig extends ListDataConfig {

    public function __construct($recordCount = 10, $isAdminCall = false) {
        parent::__construct($isAdminCall);

        $this->isArtistMenuVisible = false;

        $this->additionalRecordListCols[""] = "created";
        // $this->recordListFilters[] = "created>'2013-01-01'";

        $this->defaultOrder = 'Date(created) DESC, VideoType DESC,AudioType DESC, Artist, misc  LIMIT 0 , ' . $recordCount;
    }

}
?>
