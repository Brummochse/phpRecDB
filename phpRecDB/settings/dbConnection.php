<?php
function dbConnect() {
	include_once "dbConfig.php";
	$dbInfo=new DbConfig();
	mysql_connect($dbInfo->getHost(), $dbInfo->getUser(), $dbInfo->getPass());
	mysql_select_db($dbInfo->getDb());
}
?>
