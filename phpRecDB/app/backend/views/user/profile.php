<?php
$this->beginWidget('bootstrap.widgets.TbBox', array(
    'title' => 'View User "'.$model->username."'",
    'htmlOptions' => array('class' => 'bootstrap-box-small'),
));
?>
<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'username',
		'role',
	),
)); ?>
<?php echo CHtml::link('Change Password', array('changePassword')); ?>
<?php $this->endWidget();?>