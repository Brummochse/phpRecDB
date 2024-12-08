<?php

class CollapsableListDataConfig extends ListDataConfig {

    public function __construct($collapsed = true, $isAdminCall = false) {
        parent::__construct($isAdminCall);

        //
        $artistId = ParamHelper::decodeArtistIdParam();
        $this->isRecordListVisible = !$collapsed || $artistId != NULL;

        if ($artistId != NULL && $artistId >= 0) { // => means a artist is selected, show ONLY this artist and NOT all
            $this->recordListFilters[] = 'artists.id=' . $artistId;
        }

        //
        $this->defaultOrder = array('Artist ASC',
            'misc ASC',
            'VideoType DESC',
            'AudioType DESC',
            'Date ASC',
            'Version ASC',
            'Length DESC'
        );
    }

}

?>
