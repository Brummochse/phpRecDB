<?php

function deleteAllUnusedDbEntrys() {
    deleteUnusedConcerts();
    deleteUnusedVenues();
    deleteUnusedCitys();
    deleteUnusedCountrys();
    deleteUnusedArtists();
}

function deleteUnusedVenues() {
    $sqlDelete = "DELETE venues.*" .
            " FROM `venues`" .
            " LEFT JOIN concerts ON concerts.venues_id = venues.id" .
            " WHERE concerts.id IS NULL";
    mysql_query($sqlDelete) or die("MySQL-Error: " . mysql_error());
}
function deleteUnusedCitys() {
    $sqlDelete = "DELETE citys.*" .
            " FROM `citys`" .
            " LEFT JOIN concerts ON concerts.citys_id = citys.id" .
            " WHERE concerts.id IS NULL";
    mysql_query($sqlDelete) or die("MySQL-Error: " . mysql_error());
}
function deleteUnusedCountrys() {
    $sqlDelete = "DELETE countrys.*" .
            " FROM `countrys`" .
            " LEFT JOIN concerts ON concerts.countrys_id = countrys.id" .
            " WHERE concerts.id IS NULL";
    mysql_query($sqlDelete) or die("MySQL-Error: " . mysql_error());
}
function deleteUnusedArtists() {
    $sqlDelete = "DELETE artists.*" .
            " FROM `artists`" .
            " LEFT JOIN concerts ON concerts.artists_id = artists.id" .
            " WHERE concerts.id IS NULL";
    mysql_query($sqlDelete) or die("MySQL-Error: " . mysql_error());
}
function deleteUnusedConcerts() {
    $sqlDelete = "DELETE concerts . * " .
            "FROM `concerts` " .
            "LEFT JOIN recordings ON recordings.concerts_id = concerts.id " .
            "WHERE recordings.id IS NULL";
    mysql_query($sqlDelete) or die("MySQL-Error: " . mysql_error());
}
?>
