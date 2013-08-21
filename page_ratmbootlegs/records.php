<?php 
include "files/header.php"; 
include_once "../phpRecDB/phpRecDB.php";
$prdb=new phpRecDB();
$prdb->setTheme("ratmbootlegs");
$prdb->printList(true);
 include "files/footer.php"; 
 ?>;