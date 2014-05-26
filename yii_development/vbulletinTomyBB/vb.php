

<?

function getTimesWithSubjectVB() {
    $dbname = "raretradevbold";
    $dbhost = "localhost";
    $dbuser = "root";
    $dbpass = "";

    mysql_connect($dbhost, $dbuser, $dbpass);
    mysql_select_db($dbname);


    $timesWithSubject = array();

    $query = "SELECT dateline,title FROM pmtext";
    $result = mysql_query($query);
    $rows = mysql_num_rows($result);
    echo "<br>rows in vBulletin PMs:" . $rows . "<br>";

    while ($line = mysql_fetch_array($result)) {

        $timesWithSubject[$line["dateline"]] = $line["title"];
    }
    mysql_free_result($result);
    mysql_close();



    return $timesWithSubject;
}
