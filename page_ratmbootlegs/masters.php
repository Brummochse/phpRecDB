<?php 
include "files/header.php"; 
include_once "../phpRecDB/phpRecDB.php";
$prdb=new phpRecDB();
$prdb->printSubList('My Masters',false, 'ratmbootlegs');
 include "files/footer.php"; 
 ?>;