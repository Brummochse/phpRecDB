<?php
include "header.php";

//including the phpRecDB.php file
//after including you can use the phpRecDB commands
include_once "../phpRecDB/phpRecDB.php";

//create a new phpRecDB object
$phpRecDB=new phpRecDB();

//print a Navigation Bar
$phpRecDB->printNavigationBar();

//print a list with all records
$phpRecDB->printVideoList();

include "footer.php";
?>
