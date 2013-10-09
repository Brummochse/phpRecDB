<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'tradestatus-form',
	'enableAjaxValidation'=>false,
)); ?>
	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'label'); ?>
		<?php echo $form->textField($model,'label'); ?>
		<?php echo $form->error($model,'label'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'shortname'); ?>
		<?php echo $form->textField($model,'shortname'); ?>
		<?php echo $form->error($model,'shortname'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->