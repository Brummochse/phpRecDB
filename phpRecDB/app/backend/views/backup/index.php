<?php 
$this->renderPartial('_list', array('dataProvider'=>$dataProvider));
$this->widget('booster.widgets.TbButton', array('label' => 'Create Backup File', 'url' => array('create'), 'buttonType' =>'link','context' => 'primary'));
