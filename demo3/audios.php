<?php
include "templatefiles/header.php";

//including the phpRecDB.php file
//after including you can use the phpRecDB commands
include_once "phpRecDB/phpRecDB.php";

//create a new phpRecDB object
$phpRecDB=new phpRecDB();

?>
<div class="navbarcontainer">
<?php
//print a Navigation Bar
$phpRecDB->printNavigationBar();
?>
</div>
<?php

//print a list with records
$phpRecDB->printAudioList();
?>

<div class="navbarcontainer">
<?php
//print a Navigation Bar
$phpRecDB->printNavigationBar();
?>
</div>

<?php
include "templatefiles/footer.php";
?>
