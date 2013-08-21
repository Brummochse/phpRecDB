<?php 
include "files/header.php"; 
include_once "../phpRecDB/phpRecDB.php";
$prdb=new phpRecDB();
$prdb->setTheme("ratmbootlegs");
$prdb->printNews();
 include "files/footer.php"; 
 ?>;