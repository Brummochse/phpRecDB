<?php
include_once dirname(__FILE__) . '/../../settings/dbConfig.php';
include("include-crudfact/SQL.php");
include("include-crudfact/crudfact.php");

//istantiating classes
$dbInfo=new DbConfig();
$sql = new SQL($dbInfo->_CONFIG);
$crud = new CRUDFACT($sql,  $table);

//record list
if ( !isset ($_GET['id']) && !isset ($_GET['insert']))
{
    print "<h2>$table List</h2>"; 
    
    $crud->printRecordsList();
    print "<br /><img src='images/add16.gif' align='absmiddle'> <a href='".$crud->makeUrl(  array('insert'=>1))."'>Add $table</a>";
}
//insert/edit form

if ( $_GET['id'] || $_GET['insert'])
$crud->printCrudForm("<img src='images/products.gif'>Add a new $table","<img src='images/products.gif'> Edit $table");
//foot
?>
