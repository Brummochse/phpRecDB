<?php
/**
 * combines recordlist and recordviewer
 * 
 * 1. displays list if no record is selected
 * 2. displays record when there is a record selected
 * 
 */
class CollectionSupplier extends CWidget {

    public $data = null;

    public function run() {

        $recordId = ParamHelper::decodeRecordIdParam();

        if ($recordId != null) {
            $artistMenuItems = $this->data[RecordsListFetcher::ARTIST_ITEMS];
            $this->render("csrecord",array("artistMenuItems" => $artistMenuItems,'recordId' => $recordId));
        } else {
            $this->render("cslist",array('data' => $this->data));
            
        }
    }

}

?>
