<?php 
include "files/header.php"; 
include_once "../phpRecDB/phpRecDB.php";
$prdb=new phpRecDB();
$prdb->printArtistList('Rage Against The Machine');
 include "files/footer.php"; 
 ?>;