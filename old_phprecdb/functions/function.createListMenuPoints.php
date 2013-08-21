<?php
function createListMenuPoints(&$sites) {
	$lists=array();
	include_once dirname(__FILE__) . "/../constants.php";
	include_once Constants :: getClassFolder() . "SublistMananger.php";
	$sublistMananger = new SublistMananger();
	$subLists=$sublistMananger->getLists();
	foreach ($subLists as $listId => $listName) {
		$sites[$listName] = 'AdminSubList.php';
		$lists[]=$listName;

	}
	return $lists;
}
?>
