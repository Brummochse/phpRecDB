<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
    <head>
        <title>phpRecDB Demo</title>
    </head>
    <body>
        <center>
            <h1>phpRecDB Demo</h1>
            <a href="index.php">Home</a>
            <a href="news.php">News</a>
            <a href="records.php">Records</a>
            <br><hr><br>

            <?php
            //including the phpRecDB.php file
            //after including you can use the phpRecDB commands
            include_once "../phpRecDB/phpRecDB.php";

            //create a new phpRecDB object
            $phpRecDB=new phpRecDB();

            $phpRecDB->printList();
            ?>
        </center>
    </body>
</html>
