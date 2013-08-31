<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Downloadcounter Demo</title>
</head>
<body style="font-family: Verdana, Arial,\"Nimbus Sans L\", Helvetica ,sans-serif; background-color: #fff;">
<img alt="feenders.de" src="downloads/logo.jpg" style="float: right; margin: 10px 20px;">
<h2>Download-Counter Klasse</h2>
<p>Die Klasse Download verhindert den direkten Download einer Datei. Auf Wunsch verhindert sie auch den Aufruf des Download-Scriptes von ausserhalb der Domain.</p>
<p>Zusätzlich protokolliert sie die Anzahl der Downloads und gibt sie bei Bedarf aus.</p>
<p>Die Klasse prüft nur auf das Vorhandensein der Datei im angegebenen Downloadordner.<br/>Fileendungen werden noch nicht geprüft, sondern alle Dateien als application/octet-stream ausgegeben.</p>
<p>Dadurch werden alle Dateien unabhängig von ihrem Format als Download angezeigt und nicht im Browser geöffnet.</p>
<ul><li>Siehe: <a href="http://www.feenders.de/ratgeber/experten/398-download-von-dateien-erzwingen.html">Feenders: Download von Dateien erzwingen</a></li></ul>   
<hr/>
<ul><li>Datei blaumuster.jpg &raquo; <a href="download.php?action=download&file=test.zip">herunterladen</a></li></ul>
<p>Aufruf: "download.php?action=download&amp;file=test.zip"</p>
<hr/>
<ul><li>Downloadcounter ausgeben &raquo; <a href="download.php?file=test.zip&action=counter">ausgeben</a></li></ul>
<p>Aufruf: "download.php?action=counter&amp;file=test.zip"</p>
<hr/>
<h3>Beispiel für die Countereinbindung</h3>
<code>
<p>&lt;php</p>
<blockquote>  
	include "download.php";<br/> 
	$d = new download("blaumuster.jpg");<br/>
	echo $d->getCounter();<br/>
</blockquote>	
?&gt;
</code>
<p>Die Datei wurde <strong><span style="color:red">
<?php  

	include "download.php"; 
	$d = new download("test.zip");
	echo $d->getCounter();
	
?></span></strong> mal heruntergeladen</p>
<hr/>
<p>Grundlage für die Klasse ist folgender Beitrag.</p> 
<ul><li>Siehe: <a href="http://www.feenders.de/ratgeber/experten/198-php-download-counter-script.html">Feenders: PHP Download-counter Script</a></li></ul>
<p align="right"><small>&copy; <?php echo date("Y"); ?> computer daten netze :: feenders</small></p>   
</body>
</html>
