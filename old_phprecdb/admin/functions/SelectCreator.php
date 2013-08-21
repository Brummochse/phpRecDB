<?php
function createSelectBox($name, $tableName, $valueCol, $textRow, $currentValue,$bootlegtype=null) {
	$sqlSelect = "SELECT $valueCol, $textRow FROM $tableName";
	if ($bootlegtype!=null) {
		$sqlSelect=$sqlSelect." WHERE bootlegtypes_id=".$bootlegtype;
	}
	
	$results = mysql_query($sqlSelect) or die("MySQL-Error: " . mysql_error());
	$out = '';
	$out = "<select name='$name' size='1'>" .
	"<option value='NULL' >-</option>";
	while ($row = mysql_fetch_row($results)) {
		if ($currentValue == $row[0]) {
			$out = $out . "<option value='$row[0]' selected>$row[1]</option>";
		} else {
			$out = $out . "<option value='$row[0]'>$row[1]</option>";
		}
	}
	$out = $out . "< / select > ";
	return $out;
}
?>


	

	