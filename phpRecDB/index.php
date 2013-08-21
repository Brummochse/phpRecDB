<?
////////////generating time////////////////
$starttime = explode(' ', microtime());
$starttime = $starttime[1] + $starttime[0];
//////////////////////////////////////////
?>
<?php
        include_once "phpRecDB.php";
        $prdb = new phpRecDB();
        $prdb->adminPanel();
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