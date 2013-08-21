<?php

function getConcertInfoAsArray($recordingId) {
    $sqlSelect = "SELECT artists.name, concerts.date, countrys.name, citys.name, venues.name, concerts.supplement, concerts.misc,recordings.sourceidentification " .
            "FROM concerts " .
            "LEFT OUTER JOIN artists ON artists.id = concerts.artists_id " .
            "LEFT OUTER JOIN countrys ON countrys.id = concerts.countrys_id " .
            "LEFT OUTER JOIN citys ON citys.id = concerts.citys_id " .
            "LEFT OUTER JOIN venues ON venues.id = concerts.venues_id " .
            "LEFT OUTER JOIN recordings ON concerts.id = recordings.concerts_id " .
            "WHERE recordings.id=" . $recordingId;
    $concertInfoResult = mysql_query($sqlSelect) or die("MySQL-Error: " . mysql_error());
    $concertInfo = mysql_fetch_row($concertInfoResult);

    $sourceIdentification = $concertInfo[7];
    $miscBoolean = $concertInfo[6];

    if ($miscBoolean == '1') {
        $misc = "(MISC)";
    } else {
        $misc = '';
    }

    $concertInfo=array(
            "artist"=> stripslashes($concertInfo[0]),
            "date"=> $concertInfo[1],
            "country"=> stripslashes($concertInfo[2]),
            "city"=> stripslashes($concertInfo[3]),
            "venue"=> stripslashes($concertInfo[4]),
            "supplement"=> stripslashes($concertInfo[5]),
            "misc"=> $misc,
            "sourceidentification"=> $sourceIdentification
    );
    return $concertInfo;
}

function getConcertInfo($recordingId, $withSourceIdentification, $smarty) {
    $concertInfo=getConcertInfoAsArray($recordingId);

    foreach ($concertInfo as $key=>$value) {
        if (($withSourceIdentification== false) && ($key=="sourceidentification")) {
            continue;
        }
        $smarty->assign($key, $value);
    }
}
?>