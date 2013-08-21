
<?php
include_once dirname(__FILE__) . '/../../constants.php';
include_once  Constants::getSettingsFolder().'dbConfig.php';
include Constants::getLibsFolder()."Crud/include-crudfact/SQL.php";
include Constants::getLibsFolder()."Crud/include-crudfact/crudfact.php";
//customization

$C['bootlegtypes_id']['query_select']['q'] = "SELECT `id` AS opt, `label` as val FROM `bootlegtypes` ORDER BY `label`";
$crudconf[$table] = $C;

//istantiating classes
$dbInfo=new DbConfig();
$sql = new SQL($dbInfo->_CONFIG);
$crud = new CRUDFACT($sql,  $table,$crudconf);

//record list
if ( !$_GET['id'] && !$_GET['insert'])
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
