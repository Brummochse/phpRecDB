<?php
$this->beginWidget('bootstrap.widgets.TbBox', array(
    'title' => 'phpRecDB',
    'headerIcon' => 'icon-home',
    'htmlOptions' => array('class' => 'bootstrap-box-small'),
));

$this->widget('bootstrap.widgets.TbLabel', array( 'label'=>'script version:',)); 
echo " ".$scriptVersion; 
?>
<br>
<?php $this->widget('bootstrap.widgets.TbLabel', array('label'=>'Database version:',)); 
echo " ".$dbVersion;
?>
<br><br>
for updates check <?= CHtml::link("www.phpRecDB.de.vu","http://www.phpRecDB.de.vu"); ?>

<?php $this->endWidget();?>


<?php
echo CHtml::link('export',array('export'));


?>
