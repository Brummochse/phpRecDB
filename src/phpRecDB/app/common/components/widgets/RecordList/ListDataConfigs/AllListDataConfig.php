<?php

class AllListDataConfig extends CollapsableListDataConfig {

    public function __construct(bool $collapsed = true,bool $isAdminCall = false, array $sublistIdsToExclude=[]) {
        parent::__construct($collapsed, $isAdminCall);

        if (count($sublistIdsToExclude) > 0) {
            $filterClause = '(sublists.lists_id IS NULL OR sublists.lists_id NOT IN (' . implode(',', $sublistIdsToExclude) . '))';
            $this->recordListFilters[] = $filterClause;
            $this->artistMenuFilters[] = $filterClause;
            $this->additionalRecordListCols[] =new SqlBuildCol("sublistassignments","lists_id","");
            $this->additionalArtistMenuCols[] =new SqlBuildCol("records.sublistassignments","lists_id","");
        }
    }

}

?>
