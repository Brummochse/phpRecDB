<?
////////////generating time////////////////
$starttime = explode(' ', microtime());
$starttime = $starttime[1] + $starttime[0];
//////////////////////////////////////////
?>

<?php
header('Content-Type:text/html; charset=UTF-8');
include_once "phpRecDB/phpRecDB.php";
$prdb = new phpRecDB();
//$prdb->setTheme("ratmbootlegs");
$prdb->startInternalSite();
?>

<div style="text-align: center; font-size: 0.6em; color: grey;margin-top: 10px;">
<?
////////////generating time////////////////
$mtime = explode(' ', microtime());
$totaltime = $mtime[0] + $mtime[1] - $starttime;
printf('Page generated in %.3f seconds.', $totaltime);
//////////////////////////////////////////
?>
</div>