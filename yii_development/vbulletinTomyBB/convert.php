<?php

include "vb.php";
include "mybb.php";


    $mybbIDsWithTimes = getMybbIDsWithTimes();
    $timesWithSubjectVB = getTimesWithSubjectVB();

    echo "<br>count:" . count($mybbIDsWithTimes);
    echo "<br>count:" . count($timesWithSubjectVB);

//////////////////

    $dbname = "raretrade_new_mybb";
    $dbhost = "localhost";
    $dbuser = "root";
    $dbpass = "";

    mysql_connect($dbhost, $dbuser, $dbpass);
    mysql_select_db($dbname);

//////////////////

    $notFoundTitle = 0;
    foreach ($mybbIDsWithTimes as $myBBId => $time) {
        $subject = $timesWithSubjectVB[$time];

        echo "<br>" . $myBBId . " : " . $subject;

        $sqlupdate = "UPDATE `privatemessages` 
              SET 
                  `subject`='$subject'
              WHERE 
                  `pmid`=$myBBId";
//echo "(".$sqlupdate.")";
        mysql_query($sqlupdate);
    }

$sqlupdate="UPDATE `mybb_privatemessages` SET `folder` = '1' WHERE `folder` = '0'";
mysql_query($sqlupdate);

?>