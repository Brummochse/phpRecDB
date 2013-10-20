<?php

function test($arr) {
    $arr[]=4;
}

$a=array(1,2,3);
echo "a:<br><br>";
print_r($a);

test($a);

echo "<br><br>a:<br><br>";
print_r($a);
?>zz