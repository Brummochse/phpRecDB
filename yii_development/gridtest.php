<?php
////////////generating time////////////////
$starttime = explode(' ', microtime());
$starttime = $starttime[1] + $starttime[0];
//////////////////////////////////////////
?>
    
<?php

$dbname = "tripkore";
$dbhost = "localhost";
$dbuser = "root";
$dbpass = "";

mysql_connect($dbhost, $dbuser, $dbpass);
mysql_select_db($dbname);

$query = "select distinct recordings.id as RecordId,recordings.sumlength as Length,recordings.quality as Quality,recordings.sourceidentification as Version,concerts.id,concerts.misc,concerts.date as Date,concerts.supplement as Supplement,artists.id as ArtistId,artists.name as Artist,video.recordings_id IS NOT NULL As VideoType,audio.recordings_id IS NOT NULL As AudioType,countrys.name as Country,citys.name as City,venues.name as Venue,rectypes.shortname as Type,media.shortname as Medium,sources.shortname as Source,tradestatus.shortname as TradeStatus from recordings LEFT OUTER JOIN concerts ON concerts.id = recordings.concerts_id LEFT OUTER JOIN artists ON artists.id = concerts.artists_id LEFT JOIN video ON recordings.id = video.recordings_id LEFT JOIN audio ON recordings.id = audio.recordings_id LEFT OUTER JOIN countrys ON countrys.id = concerts.countrys_id LEFT OUTER JOIN citys ON citys.id = concerts.citys_id LEFT OUTER JOIN venues ON venues.id = concerts.venues_id LEFT OUTER JOIN rectypes ON rectypes.id = recordings.rectypes_id LEFT OUTER JOIN media ON media.id = recordings.media_id LEFT OUTER JOIN sources ON sources.id = recordings.sources_id LEFT OUTER JOIN tradestatus ON tradestatus.id = recordings.tradestatus_id WHERE recordings.visible=true";
$result = mysql_query($query);
$colCounts = mysql_num_fields($result);

echo "<table>";
echo "<th>";
for ($i=0;$i<$colCounts;$i++) {
    echo "<td>".$i."</td>";
}
echo "</th>";

while ($line = mysql_fetch_array($result)) {
    echo "<tr>";
       for ($i=0;$i<$colCounts;$i++) {
            echo "<td>".$line[$i]."</td>";
        }
    echo "</tr>";
}

echo "</table>";

?>

<?php
////////////generating time////////////////
$mtime = explode(' ', microtime());
$totaltime = $mtime[0] + $mtime[1] - $starttime;
printf('Page generated in %.3f seconds.', $totaltime);
//////////////////////////////////////////
?>
