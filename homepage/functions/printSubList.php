<h2>printSubList($subListName)</h2>

<div class="description">
this function prints a list with all records, which belong to this list.<br/>
in the administration area you can create and manage sub-lists.<br/><br/>
In this example you must create a sublist 'My Master' in the administration area in Configuration/lists
</div>

Example:
<div class="code">
            &lt;?php<br>
            include_once "phpRecDB/phpRecDB.php";<br>
            $phpRecDB=new phpRecDB();<br>
            $phpRecDB->printSubList('My Masters');<br>
            ?&gt;
</div>