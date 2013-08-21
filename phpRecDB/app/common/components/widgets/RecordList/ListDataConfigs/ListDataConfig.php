<?php

abstract class ListDataConfig {

    private $isAdmin = false;
    protected $recordListFilters = array();
    protected $artistMenuFilters = array();
    protected $isRecordListVisible = true;
    protected $isArtistMenuVisible = true;
    protected $additionalRecordListCols = array();
    protected $additionalArtistMenuCols = array();
    protected $defaultOrder = '';
    protected $sortAttributes = array();

    public function __construct($isAdminCall = false) {
        $this->setAdminMode($isAdminCall);
    }

    private function setAdminMode($isAdminCall = false) {
        //double check if admin
        $this->isAdmin = !Yii::app()->user->isGuest && $isAdminCall;

        if (!$this->isAdmin) { // => isGuest
            $this->recordListFilters[] = 'recordings.visible=true'; //do not show invisible records
            $this->artistMenuFilters[] = 'recordings.visible=true'; //do not show artists which have only invisible records
        }
    }

    public function setVideoAudioSelection($va) {

        switch ($va) {
            case VA::AUDIO:
                $this->additionalArtistMenuCols["records.audio"] = "recordings_id IS NOT NULL As AudioType";
                $this->recordListFilters[] = 'audio.recordings_id IS NOT NULL';
                $this->artistMenuFilters[] = 'audio.recordings_id IS NOT NULL';
                break;
            case VA::VIDEO:
                $this->additionalArtistMenuCols["records.video"] = "recordings_id IS NOT NULL As VideoType";
                $this->recordListFilters[] = 'video.recordings_id IS NOT NULL';
                $this->artistMenuFilters[] = 'video.recordings_id IS NOT NULL';
                break;
            default: // =VA::VIDEO_AND_AUDIO
                break;
        }
    }

    public function getRecordListFilters() {
        return $this->recordListFilters;
    }

    public function getArtistMenuFilters() {
        return $this->artistMenuFilters;
    }

    public function isAdmin() {
        return $this->isAdmin;
    }

    public function getAdditionalArtistMenuCols() {
        return $this->additionalArtistMenuCols;
    }

    public function getAdditionalRecordListCols() {
        return $this->additionalRecordListCols;
    }

    public function isRecordListVisible() {
        return $this->isRecordListVisible;
    }

    public function isArtistMenuVisible() {
        return $this->isArtistMenuVisible;
    }

    public function getDefaultOrder() {
        return $this->defaultOrder;
    }

    public function getSortAttributes() {
        return $this->sortAttributes;
    }

}

?>
