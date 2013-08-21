<?php
$results = array ();
$searchValue = isset ($_GET['v']) ? $_GET['v'] : '';
$searchType = isset ($_GET['t']) ? $_GET['t'] : '';

//if ($searchValue != '') {
	$sqlQuery = createQuery($searchType, $searchValue);
	$results = getProposals($sqlQuery);
	if (count($results) > 0) {
		sort($results);
		echo implode($results, ';');
	}
//} 
exit ();

function getProposals($sqlQuery) {
	include "../settings/dbConnection.php";
	dbConnect();

	$queryResults = mysql_query($sqlQuery);
	if (mysql_errno())
		die("MySQL-Error: " . mysql_error());

	while ($queryResultRow = mysql_fetch_row($queryResults)) {
		$results[] = stripslashes(utf8_encode($queryResultRow[0]));
	}

	return $results;
}

function createQuery($searchType, $searchValue) {
	if ($searchType == 'artist') {
		return "SELECT name FROM artists WHERE name LIKE '" . $searchValue . "%' ORDER BY name";
	} else
		if ($searchType == 'country') {
			return "SELECT name FROM countrys WHERE name LIKE '" . $searchValue . "%' ORDER BY name";
		} else
			if ($searchType == 'city') {
				$countryName = isset ($_GET['country']) ? $_GET['country'] : '';
				return "SELECT citys.name FROM citys,countrys WHERE citys.countrys_id=countrys.id AND countrys.name='" . $countryName . "' AND citys.name LIKE '" . $searchValue . "%' ORDER BY citys.name";
			} else
				if ($searchType == 'venue') {
					$cityName = isset ($_GET['city']) ? $_GET['city'] : '';
					$countryName = isset ($_GET['country']) ? $_GET['country'] : '';
					return "SELECT venues.name FROM citys,venues,countrys WHERE citys.countrys_id=countrys.id AND countrys.name='" . $countryName . "' AND venues.citys_id=citys.id AND citys.name='" . $cityName . "' AND venues.name LIKE '" . $searchValue . "%' ORDER BY venues.name";
				} else
					return null;
}
?>

