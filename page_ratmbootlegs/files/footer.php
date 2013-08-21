        <div style="text-align:center;margin-top:20px;font-size:9px;color:#444444" />
        <?
        ////////////generating time////////////////
        $mtime = explode(' ', microtime());
        $totaltime = $mtime[0] + $mtime[1] - $starttime;
        printf('Page generated in %.3f seconds.', $totaltime);
        //////////////////////////////////////////
        ?>
    </body>
</html>