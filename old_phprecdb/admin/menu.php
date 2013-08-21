<?php
include_once ('../libs/Smarty/Smarty.class.php');
include_once dirname(__FILE__) . "/../constants.php";
include_once (Constants :: getClassFolder() . 'Linky.php');

include_once "sitemap.php";
$sectionLinky = new Linky(Constants::getParamAdminMenuIndex());
$indexSite = "index.php";

$menuLevels = array (
	0 => "chapters",
	1 => "sections",
	2 => "subsections"
);

function createNextMenuStructureLevel($parent, $menuLevel) {
	global $menuLevels;
	global $indexSite;
	global $sectionLinky;
	global $sites;

	$menuPoints = array ();
	foreach ($parent as $childName => $childs) {
		$menuPoint = array ();

		if (is_array($childs)) {
			$subMenuPoint = createNextMenuStructureLevel($childs, $menuLevel +1);
			$menuPoint['name'] = $childName;
			$menuPoint[$menuLevels[$menuLevel +1]] = $subMenuPoint;
			$test = $menuLevels[$menuLevel +1];
		} else {

			$menuPoint['name'] = $childs;
			$menuPoint['link'] = $indexSite . $sectionLinky->encryptName($childs);
		}

		$menuPoints[] = $menuPoint;
	}
	return $menuPoints;
}

$chapters = createNextMenuStructureLevel($menuStructure, 0);

$logout = array (
	'name' => 'logout',
	'link' => $indexSite . '?action=logout'
);
array_push($chapters, $logout);

$smarty->assign('chapters', $chapters);

?>
