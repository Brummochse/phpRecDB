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

$file_handle = fopen( dirname(__FILE__). "/wants.csv", "r");
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

function col($innerHtml) {
    return '<td>'.$innerHtml.'</td>';
}

?>

<style>
    #wants  {
          border: 1px solid #4F4F4F;
  border-collapse: collapse;
    }    
</style>


<table id="wants" border="1" >
    <thead><tr><td>Artist</td><td>Date</td><td>Location</td></tr></thead>


<?php
foreach ($wants as $want) {
    echo '<tr>';
    echo col($want->artist).col($want->date).col($want->location);// ." ".    $want->comment."<br>";
    echo '</tr>';
}
?>

    </table>