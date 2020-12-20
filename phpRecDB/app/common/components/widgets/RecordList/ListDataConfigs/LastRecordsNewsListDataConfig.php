<?php

class LastRecordsNewsListDataConfig extends ListDataConfig {

    public function __construct($recordCount = 10, $isAdminCall = false) {
        parent::__construct($isAdminCall);

        $this->isArtistMenuVisible = false;

        $this->additionalRecordListCols[] = new SqlBuildCol("","created","");

        $this->defaultOrder = array(
            'Date (created) DESC', //this is dirty workaround "Date" is in this case a mysql function and NOT the Cols::Date colname. it works in the getDefaultOrder() check, because "Date" is always required, so this should work
            'VideoType DESC',
            'AudioType DESC',
            'Artist ASC',
        );

        $this->limit = $recordCount;
    }

}

?>
