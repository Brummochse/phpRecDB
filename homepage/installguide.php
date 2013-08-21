<p>This guide explains how to set up the phpRecDB script on your own webspace!<br>
sorry for the german screenshots :-)</p>

<p><h3>What requirements do i need for using phpRecDB?</h3>
	- a webspace which supports MySQL and PHP 5<br>
	- knowledge how to use a ftp client<br/>
	- knowledge how to use phpMyAdmin</p>
	
<p><h3>1.</h3> download and decompress the phpRecDB Script AND the phpRecDB database schema</p>

<p><h3>2.</h3> create a new MySQL database (for example 'phprecdb')<p>

<p><h3>3.</h3> open phpMyAdmin, select the new database and click on "import" and import the phpRecDB.sql into your database<br>
<img src="installation/import.jpg"></p>

<p><h3>4.</h3> open the file 'dbConfig.php' with a texteditor (for example notepad). <br>
You can find this file in the folder 'phpRecDB/settings/'. <br>
In this file you must edit the database connection infos. <br>
This step is important that the script can connect to the database.<br>
<img src="installation/dbsettings.jpg"><br/>
The hostname you will find on the website of your webspace provider (in the most cases it is 'localhost')<br>
Username and password are required for accessing the datebase.<br>
the datebase name is the name of the database which you created in step 2.
</p>

<p><h3>5.</h3> after editing the dbConfig.php file, you can upload the whole phpRecDB script to your webspace.<br>
When everything is ok, now the demo application should run on your own webspace!</p>

<p><h3>6.</h3> open the demo site and switch to the adminstration panal. After installing you can login in with:<br/>
Username: <b>admin</b><br>
Password: <b>secret</b><br><br/>
Navigate to the menu Configuration/User management and change the password!!<br/>
<img src="installation/changepassword.jpg">
</p>

<p><h3>finished!</h3></p>
