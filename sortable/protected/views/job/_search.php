<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'jid'); ?>
		<?php echo $form->textField($model,'jid'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'jdesc'); ?>
		<?php echo $form->textField($model,'jdesc',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->