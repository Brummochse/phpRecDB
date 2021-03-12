<?php

class SublistListDataConfig extends CollapsableListDataConfig {

    public function __construct($sublistId, $collapsed = true, $isAdminCall = false) {

        parent::__construct($collapsed, $isAdminCall);

        if ($sublistId != NULL) {
            $this->recordListFilters[] = 'sublists.lists_id=' . $sublistId;
            $this->artistMenuFilters[] = 'sublists.lists_id=' . $sublistId;

            $this->additionalRecordListCols[] =new SqlBuildCol("sublistassignments","lists_id","");
            $this->additionalArtistMenuCols[] =new SqlBuildCol("records.sublistassignments","lists_id","");
        }
    }

}

?>
