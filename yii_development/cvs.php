<?php

class Want {

    public $artist;
    public $date;
    public $location;
    public $comment;
    public $pictures = array();
    public $links = array();

}

$wants = array();

$file_handle = fopen("wants.csv", "r");
while (!feof($file_handle)) {

    $parts = fgetcsv($file_handle,0,";");

    if (count($parts)>=3) {

        
        $want = new Want();
        $want->artist = $parts[0];
        $want->date = $parts[1];
        $want->location = $parts[2];
        $want->comment = $parts[3];
        $wants[]=$want;
    }
}
fclose($file_handle);

foreach ($wants as $want) {
    echo $want->artist ." ".  $want->date ." ".   $want->location ." ".    $want->comment."<br>";
}