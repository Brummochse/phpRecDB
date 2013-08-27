<?php
include "header.php";

//including the phpRecDB.php file
//after including you can use the phpRecDB commands
include_once "../phpRecDB/phpRecDB.php";

//create a new phpRecDB object
$phpRecDB=new phpRecDB();

//print a Navigation Bar
$phpRecDB->printNavigationBar();

//print a list with records, which belong to the sublist 'My Favorites'
//this sublsit must be defined in the administration area in Configurations/lists
$phpRecDB->printSubList('My Favorites');

include "footer.php";
?>
