<h2>printNews([$newsCount [, $newsType]])</h2>


<div class="description">
this function prints a list, with all records added in the last time 
</div>

Example:
<div class="code">
            &lt;?php<br>
            include_once "phpRecDB/phpRecDB.php";<br>
            $phpRecDB=new phpRecDB();<br>
            $phpRecDB->printNews();<br>
            ?&gt;
</div>


<div class="description">
You can control how many records should be displayed in the news list.
<br><br>
There are 3 different displaying-types for news:
<table>
<tr>
    <td><b>LAST_RECORDS</b></td>
    <td>number of shows in chronological order</td>
</tr>
<tr>
    <td><b>LAST_DAYS</b></td>
    <td>number of last active days with all records added at this last days</td>
</tr>
<tr>    
    <td><b>LAST_RECORDS_PER_DAY</b></td>
    <td>number of shows in alphabetical order per day</td>
</tr>
</table>
</div>

The next example prints a list with the last 10 added records in in alphabetical order per day:
<div class="code">
            &lt;?php<br>
            include_once "phpRecDB/phpRecDB.php";<br>
            $phpRecDB=new phpRecDB();<br>
            $phpRecDB->printNews(10,LAST_RECORDS_PER_DAY);<br>
            ?&gt;
</div>

<div class="description">
You can use this function without the parameters. standard is $newsCount=5 and $newsType=LAST_DAYS;
</div>