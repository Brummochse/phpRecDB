<?

////////////generating time////////////////
$starttime = explode(' ', microtime());
$starttime = $starttime[1] + $starttime[0];
//////////////////////////////////////////
?>

<?php

require_once(dirname(__FILE__) . '/bootstrap.php');

//$oParser = new Sabberworm\CSS\Parser(file_get_contents(dirname(__FILE__).'/files/important.css'));
$oParser = new Sabberworm\CSS\Parser(file_get_contents('D:\Programmierung\php\Projekte\phpRecDB_git_repo\phpRecDB\app\protected\extensions\mbmenu\source\mbmenu.css'));

$oDoc = $oParser->parse();

$selectors=$oDoc->getAllDeclarationBlocks();

foreach($oDoc->getAllDeclarationBlocks() as $oBlock) {
    echo "-------------------------------<br>";
    foreach($oBlock->getSelectors() as $oSelector) {
        //Loop over all selector parts (the comma-separated strings in a selector) and prepend the id
        $oSelector->setSelector('#lala '.$oSelector->getSelector());
        var_dump($oSelector);
    }
}

echo '#### Structure (`var_dump()`)' . "\n";


//foreach ($selectors as $key=>$value) {
//    var_dump($key);
//      var_dump($value);
//}

echo '#### Output (`__toString()`)' . "\n<br>";
print $oDoc->__toString();
echo "\n";


////////////generating time////////////////
$mtime = explode(' ', microtime());
$totaltime = $mtime[0] + $mtime[1] - $starttime;
printf('Page generated in %.3f seconds.', $totaltime);
//////////////////////////////////////////
?>