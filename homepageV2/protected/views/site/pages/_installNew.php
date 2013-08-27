<h1>Guide: New Installation</h1>

<p>This guide explains how to set up a <em>complete new</em> phpRecDB script on your own webspace!<br>
sorry for the german screenshots :-)</p>

<p><h2>What requirements do i need for using phpRecDB?</h2>
	- a webspace which supports MySQL and PHP 5<br>
	- knowledge how to use a ftp client<br/>
	- knowledge how to use phpMyAdmin</p>
	
<p><h2>step 1.</h2> download and decompress the phpRecDB Script AND the phpRecDB database schema</p>

<p><h2>step 2.</h2> create a new MySQL database (for example 'phprecdb')<p>

<p><h2>step 3.</h2> open phpMyAdmin, select the new database and click on "import" and import the phpRecDB.sql into your database<br>
<?php echo CHtml::image(Yii::app()->baseUrl . '/www/img/install/import.jpg'); ?></p>

<p><h2>step 4.</h2> open the file 'dbConfig.php' with a texteditor (for example notepad). <br>
You can find this file in the folder 'phpRecDB/settings/'. <br>
In this file you must edit the database connection infos. <br>
This step is important that the script can connect to the database.<br>
<?php echo CHtml::image(Yii::app()->baseUrl . '/www/img/install/dbsettings.jpg'); ?><br>
The hostname you will find on the website of your webspace provider (in the most cases it is 'localhost')<br>
Username and password are required for accessing the datebase.<br>
the datebase name is the name of the database which you created in step 2.
</p>

<p><h2>step 5.</h2> after editing the dbConfig.php file, you can upload the whole phpRecDB script to your webspace.<br>
When everything is ok, now the demo application should run on your own webspace!</p>

<p><h2>step 6.</h2> open the demo site and switch to the adminstration panal, log in and change the default user password.<br/></p>

<p><h2>finished!</h2></p>
