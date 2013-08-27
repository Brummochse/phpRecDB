<?php
include "header.php";

//including the phpRecDB.php file
//after including you can use the phpRecDB commands
include_once "../phpRecDB/phpRecDB.php";

//create a new phpRecDB object
$phpRecDB=new phpRecDB();

//print a Navigation Bar
$phpRecDB->printNavigationBar();
?>

<h2>The 5 last added Bootlegs:</h2>

<?php
//print a list with all records
$phpRecDB->printNews(5, LAST_RECORDS);

include "footer.php";
?>
