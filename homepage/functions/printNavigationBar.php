<h2>printNavigationBar()</h2>

<div class="description">
this function prints a navigation bar, which ca nbe used when browsing through a list.<br>
you can use this navigation bar only when you use a list on the same site.
</div>

Example:
<div class="code">
            &lt;?php<br>
            include_once "phpRecDB/phpRecDB.php";<br>
            $phpRecDB=new phpRecDB();<br>
            $phpRecDB->printNavigationBar();<br>
            $phpRecDB->printAudioNews();<br>
            ?&gt;
</div>