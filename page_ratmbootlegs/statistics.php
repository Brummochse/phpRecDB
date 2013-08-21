<?php 
include "files/header.php"; 
include_once "../phpRecDB/phpRecDB.php";
$prdb=new phpRecDB();
$prdb->setTheme("ratmbootlegs");
$prdb->printStatistics('ratmbootlegs');
 include "files/footer.php"; 
 ?>;