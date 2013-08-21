<?php
include "templatefiles/header.php";

//including the phpRecDB.php file
//after including you can use the phpRecDB commands
include_once "../phpRecDB/phpRecDB.php";

//create a new phpRecDB object
$phpRecDB = new phpRecDB();

//print statistics
$phpRecDB->printStatistics();

include "templatefiles/footer.php";
?>
