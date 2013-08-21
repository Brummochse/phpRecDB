<?php

class RecordsForArtistDataConfig extends AllListDataConfig {

    public function __construct($artistId, $isAdminCall = false) {
        $_GET[ParamHelper::PARAM_ARTIST_ID] = $artistId;
        $this->isArtistMenuVisible = false;
        parent::__construct($isAdminCall);
    }

}
?>
