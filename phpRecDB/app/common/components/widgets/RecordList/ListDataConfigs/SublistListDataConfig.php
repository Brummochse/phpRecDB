<?php

class SublistListDataConfig extends CollapsableListDataConfig {

    public function __construct($sublistId, $collapsed = true, $isAdminCall = false) {

        parent::__construct($collapsed, $isAdminCall);

        if ($sublistId != NULL) {
            $this->recordListFilters[] = 'sublists.lists_id=' . $sublistId;
            $this->artistMenuFilters[] = 'sublists.lists_id=' . $sublistId;

            $this->additionalRecordListCols["sublistassignment"] = "lists_id";
            $this->additionalArtistMenuCols["records.sublistassignment"] = array("lists_id");
        }
    }

}

?>
