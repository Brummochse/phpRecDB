<?php

class RecordList extends CWidget {

    public $data = null;
    public $id = "recordlist";

    public function run() {
        if ($this->data != null) {

            $artistMenuItems = $this->data[RecordsListFetcher::ARTIST_ITEMS];
            $listDataProvider = $this->data[RecordsListFetcher::DATA_PROVIDER];
            $listColumns = $this->data[RecordsListFetcher::COLUMNS];

            echo '<div id="artistMenu">';
            $this->widget("DropdownMenu",array("items" => $artistMenuItems));
            echo '</div>';
            
            if ($listDataProvider != NULL) {
                $this->render("list", array(
                    'listDataProvider' => $listDataProvider,
                    'listColumns' => $listColumns,
                    'id'=>$this->id,
                ));
            }
        }
    }

}

?>
