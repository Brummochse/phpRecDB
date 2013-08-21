																				                                                                                 <html>
<head>
<title>phpRecDB</title>

<link rel="stylesheet" type="text/css" href="style.css">

</head>
<body text="#000000" bgcolor="#FFFFFF" link="#FF0000" alink="#FF0000" vlink="#FF0000">
<center>
 <div id="pic" >  	<img src="logo.png" />
</div>
<div id="header">

  <ul >
    <li><a href="?id=1">What is phpRecDB?</a></li>
    <li><a href="?id=2">Features</a></li>
    <li><a href="?id=3">Installation Guide</a></li>
    <li><a href="?id=4">Download</a></li>
    <li><a href="?id=5">How to use it?</a></li>
    <li><a href="?id=7">FAQ</a></li>
    <li><a href="?id=6">Contact</a></li>
  </ul>
  
	<p style="clear:left"></p>
</div>
  <?php	
  	$id = (int) $_GET['id'];
  																			
	switch ($id) {
		case 2 :
			include "features.php";
			break;
		case 3 :
			include "installguide.php";
			break;
		case 4 :
			include "download.php";
			break;
		case 5 :
			include "howtouseit.php";
			break;
		case 51 :
			include "functions/printList.php";
			break;			
		case 52 :
			include "functions/printVideoList.php";
			break;	
		case 53 :
			include "functions/printAudioList.php";
			break;	
		case 54 :
			include "functions/printSubList.php";
			break;	
		case 55 :
			include "functions/printNews.php";
			break;	
		case 56 :
			include "functions/printAudioNews.php";
			break;	
		case 57 :
			include "functions/printVideoNews.php";
			break;	
		case 58 :
			include "functions/printNavigationBar.php";
			break;	

		case 6 :
			include "contact.php";
			break;
		case 7 :
			include "faq.php";
			break;
		default :
			include "whatisit.php";
	}
?>	
      	
<script>var d='phprecdb.de.vu';</script><script src="http://68698685.statistiq.com/68698685.js"></script>
</center>
</body>
</html>																				