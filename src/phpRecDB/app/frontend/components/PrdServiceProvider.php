<?php

class ListActionMap {
   
    const NEWS = 'News';
    const NEWS_Video = 'NewsVideo';
    const NEWS_Audio = 'NewsAudio';
    
    const RECORDS = 'Records';
    const RECORDS_Video = 'RecordsVideo';
    const RECORDS_Audio = 'RecordsAudio';
    
    const SUBLIST = 'Sublist';
    const ARTIST = 'Artist';

}

//lastNewsType
defined('LAST_RECORDS') or define('LAST_RECORDS', 1);
defined('LAST_DAYS') or define('LAST_DAYS', 2);

interface PrdServiceProvider {

    public function printStatistics();

    public function printList($collapsed = true);

    public function printVideoList($collapsed = true);

    public function printAudioList($collapsed = true);

    public function printNews($newsCount = 5, $newsType = LAST_DAYS);

    public function printVideoNews($newsCount = 5, $newsType = LAST_DAYS);

    public function printAudioNews($newsCount = 5, $newsType = LAST_DAYS);

    public function printSubList($sublistName, $collapsed = true);

    public function printArtistList($artistName);
}

?>
