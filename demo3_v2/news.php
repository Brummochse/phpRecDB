 <?php
include "templatefiles/header.php";

//including the phpRecDB.php file
//after including you can use the phpRecDB commands
include_once "../phpRecDB/phpRecDB.php";

//create a new phpRecDB object
$phpRecDB = new phpRecDB();
$phpRecDB->setTheme("darkgreen");

//print a list with all new records
$phpRecDB->printNews();

include "templatefiles/footer.php";
?>

