<p><h1>demo application</h1>
The script contains the <a href="demo/">demo application</a>, where you can see how to use it on your own website.<br>
the demo applications consists of this 5 files:<br>

  <ul>
    <li><b>index.php</b><br/>
    	contains the link to the administration panel.
    </li>
    <li><b>news.php</b><br/>
   		a list with all records added the last 5 active days
    </li>
    <li><b>records.php</b><br/>
    	the full list with all records
    </li>
  </ul>
 </p>
 
 <p><h1>How to use it?</h1>
 When you want use phpRecDB functions you must first include the main file "phpRecDB.php" which is included in the "phpRecDB"-folder.<br/>
 <img src="howtouseit/code1.jpg"><br>
 After including the "phpRecDB.php"-file you must create a phpRecDB-object<br>
 <img src="howtouseit/code2.jpg"><br>
 Now you can access to all the functions. For example printing the list with video records:<br>
  <img src="howtouseit/code3.jpg">
  </p>
  
  <p><h1>What functions can i use?</h1>
  Currently following functions are available:<br>
  <ul>
    <li><a href="?id=51"><b>printList()</b></a><br/>
    	prints the full list with all records
    </li>
    <li><a href="?id=52"><b>printVideoList()</b></a><br/>
    	prints the list with all video records
    </li>
    <li><a href="?id=53"><b>printAudioList()</b></a><br/>
   	 	prints the list with all audio records
    </li>
    <li><a href="?id=54"><b>printSubList('name of the list')</b></a><br/>
   	 	prints the list with all records, which belong to this list
    </li>
    <li><a href="?id=55"><b>printNews()</b></a><br/>
    	a list with all records added in the last time 
    </li>        
    <li><a href="?id=56"><b>printVideoNews()</b></a><br/>
    	a list with all video records added in the last time
    </li>
    <li><a href="?id=57"><b>printAudioNews()</b></a><br/>
   		a list with all audio records added in the last time
    </li>
    <li><a href="?id=58"><b>printNavigationBar()</b></a><br/>
   		prints a navigation bar
    </li>
  </ul>
  </p>