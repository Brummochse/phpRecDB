<?
////////////generating time////////////////
$starttime = explode(' ', microtime());
$starttime = $starttime[1] + $starttime[0];
//////////////////////////////////////////
?>
<html>
    <header>
        <title>test</title>
        <style>
            .colTest1 {
                font-weight: bolder;
            }
            .colTest2 {
                background: #00FF00;
            }
            .colTest2 {
                background: #00FF00;
                font-size: 20px;
            }
            .colTest3 {
                background: #0000FF;
            }
            .colTest4 {
                background: #FF00FF;
            }
            .colTest5 {
                background: #00FF00;
            }
            .colTest6 {
                background: #00FF00;
            }
            .colTest7 {
                background: #00FF00;
            }
            .colTest8 {
                background: #00FF00;
            }
            .colTest9 {
                background: #00FF00;
            }


        </style>
    </header>
    <body>
        <table>




            <?php
            $maxRow = 5000;
            $maxCols = 10;


            
            function writeTd($class) {
                 echo "<td".$class.">test</td>";
            }

            for ($i = 1; $i <= $maxRow; $i++) {
                echo "<tr>";
                for ($col = 0; $col < $maxCols; $col++) {
                    $class= ' class="colTest'.$col.'"';
                    writeTd($class);
                }


                echo "</tr>";
            }
            ?>
        </table>
    </body>
</html>
<?php
////////////generating time////////////////
$mtime = explode(' ', microtime());
$totaltime = $mtime[0] + $mtime[1] - $starttime;
printf('Page generated in %.3f seconds.', $totaltime);
//////////////////////////////////////////
?>
</div>