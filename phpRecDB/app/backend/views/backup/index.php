<?php 
$this->renderPartial('_list', array(
		'dataProvider'=>$dataProvider,
));

echo CHtml::link('Create Backup File', array('create'));

?>
