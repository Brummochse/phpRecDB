<?

function getMybbIDsWithTimes() {
    $dbname = "raretrade_new_mybb";
    $dbhost = "localhost";
    $dbuser = "root";
    $dbpass = "";

    mysql_connect($dbhost, $dbuser, $dbpass);
    mysql_select_db($dbname);



    $IdsWithTimes = array();
    $query = "SELECT dateline,pmid FROM privatemessages";
    $result = mysql_query($query);
    $rows = mysql_num_rows($result);
    echo "<br>rows in MyBB PMs:" . $rows . "<br>";


    while ($line = mysql_fetch_array($result)) {

        $IdsWithTimes[$line["pmid"]] = $line["dateline"];
    }
    mysql_free_result($result);
    mysql_close();

    return $IdsWithTimes;
}
