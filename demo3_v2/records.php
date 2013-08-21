<?php
include "templatefiles/header.php";

//including the phpRecDB.php file
//after including you can use the phpRecDB commands
include_once "../phpRecDB/phpRecDB.php";

//create a new phpRecDB object
$phpRecDB = new phpRecDB();

//print a list with all new records
$phpRecDB->printList(false);

include "templatefiles/footer.php";
?>

