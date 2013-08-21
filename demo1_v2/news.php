<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
    <head>
        <title>phpRecDB Demo</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    </head>
    <body>
        <center>
            <h1>phpRecDB Demo</h1>
            <a href="index.php">Home</a>
            <a href="news.php">News</a>
            <a href="records.php">Records</a>
            <a href="statistics.php">Statistics</a>
            <br><hr><br>

            <?php
            //including the phpRecDB.php file
            //after including you can use the phpRecDB commands
            include_once "../phpRecDB/phpRecDB.php";

            //create a new phpRecDB object
            $phpRecDB=new phpRecDB();
            $phpRecDB->setTheme("default");
            
            //print a list with all new records
            $phpRecDB->printNews(5,LAST_DAYS);
            ?>
        </center>
    </body>
</html>
