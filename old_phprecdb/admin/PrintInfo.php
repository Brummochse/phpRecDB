<?php
include_once dirname(__FILE__) . "/../constants.php";
include_once Constants::getLibsFolder() . "SimpleMember/adminpro_class.php";
$prot = new protect("0", "1");
?>

<html>
<head>
<style type="text/css">

</style>

</head>
<body>
<?php


if ($prot->showPage) {

	include_once "../constants.php";
	include_once ('../libs/Smarty/Smarty.class.php');

	$smarty = new Smarty;
	$smarty->template_dir = Constants::getTemplateFolder();
	$smarty->compile_dir = Constants::getCompileFolder();

	if (isset ($_GET['id'])) {
		$recordingId = (int) $_GET['id'];
		include "../settings/dbConnection.php";
		dbConnect();

		$sqlSelect = "SELECT  recordings.sumlength,media.label,rectypes.shortname,sources.label,recordings.quality,tradestatus.label,recordings.created,recordings.lastmodified,recordings.summedia,aspectratio.label,videoformat.label,video.bitrate,recordings.sourcenotes,recordings.taper,recordings.transferer,video.authorer,recordings.setlist,recordings.notes " .
		"FROM recordings " .
		"LEFT OUTER JOIN media ON media.id = recordings.media_id " .
		"LEFT OUTER JOIN rectypes ON rectypes.id = recordings.rectypes_id " .
		"LEFT OUTER JOIN sources ON sources.id = recordings.sources_id " .
		"LEFT OUTER JOIN tradestatus ON tradestatus.id = recordings.tradestatus_id " .
		"LEFT OUTER JOIN video ON video.recordings_id = recordings.id " .
		"LEFT OUTER JOIN aspectratio ON aspectratio.id = video.aspectratio_id " .
		"LEFT OUTER JOIN videoformat ON videoformat.id = video.videoformat_id " .
		"WHERE recordings.id=" . $recordingId;
		$concerts = mysql_query($sqlSelect) or die("MySQL-Error: " . mysql_error());
		$concert = mysql_fetch_row($concerts);

		$sumLength = $concert[0];
		$medium = $concert[1];
		$rectype = $concert[2];
		$source = $concert[3];
		$quality = $concert[4];
		$tradestatus = $concert[5];
		$created = $concert[6];
		$lastmodified = $concert[7];
		$sumMedia = $concert[8];
		$aspectRatio = $concert[9];
		$videoformat = $concert[10];
		$bitrate = $concert[11];
		$sourcenotes = stripslashes($concert[12]);
		$taper = stripslashes($concert[13]);
		$transferer = stripslashes($concert[14]);
		$authorer = stripslashes($concert[15]);
		$setlist = stripslashes($concert[16]);
		$notes = stripslashes($concert[17]);

		if (!empty ($sumMedia) && $sumMedia > 1) {
			for ($i = 1; $i <= $sumMedia; $i++) {
				echo getConcertInfoHtml($recordingId, true);
				echo "<br><font face='Arial'  size='-3' color='#FFFFFF'>_</font><br>";
				if (!empty ($sumLength)) {
					echo "$sumLength min / ";
				}
				if (!empty ($rectype)) {
					echo "$rectype / ";
				}
				if (!empty ($source)) {
					echo "Source: $source";
				}

				echo "<br><font face='Arial'  size='-3' color='#FFFFFF'>_</font><br><b>DVD $i/$sumMedia</b><br><br>";
			}
		} else {
			echo getConcertInfoHtml($recordingId, true);
			echo "<br><font face='Arial'  size='-3' color='#FFFFFF'>_</font><br>";
			if (!empty ($sumLength)) {
				echo "$sumLength min / ";
			}
			if (!empty ($rectype)) {
				echo "$rectype / ";
			}
			if (!empty ($source)) {
				echo "Source: $source";
			}
		}
	}
}

function getConcertInfoHtml($recordingId, $withSourceIdentification) {
	$sqlSelect = "SELECT artists.name, concerts.date, countrys.name, citys.name, venues.name, concerts.supplement, concerts.misc,recordings.sourceidentification " .
	"FROM concerts " .
	"LEFT OUTER JOIN artists ON artists.id = concerts.artists_id " .
	"LEFT OUTER JOIN countrys ON countrys.id = concerts.countrys_id " .
	"LEFT OUTER JOIN citys ON citys.id = concerts.citys_id " .
	"LEFT OUTER JOIN venues ON venues.id = concerts.venues_id " .
	"LEFT OUTER JOIN recordings ON concerts.id = recordings.concerts_id " .
	"WHERE recordings.id=" . $recordingId;
	$concertInfoResult = mysql_query($sqlSelect) or die("MySQL-Error: " . mysql_error());
	$concertInfo = mysql_fetch_row($concertInfoResult);

	$sourceIdentification = $concertInfo[7];
	$miscBoolean = $concertInfo[6];

	if (!$withSourceIdentification)
		$sourceIdentification = '';
	if ($miscBoolean == '1') {
		$misc = "(MISC)";
	} else {
		$misc = '';
	}
	global $smarty;
	$smarty->assign("artist", stripslashes($concertInfo[0]));
	$smarty->assign("date", $concertInfo[1]);
	$smarty->assign("country", stripslashes($concertInfo[2]));
	$smarty->assign("city", stripslashes($concertInfo[3]));
	$smarty->assign("venue", stripslashes($concertInfo[4]));
	$smarty->assign("supplement", stripslashes($concertInfo[5]));
	$smarty->assign("misc", $misc);
	$smarty->assign("sourceidentification", $sourceIdentification);
	$smarty->display("admin/printInfo.tpl");
}
?>
</body>
