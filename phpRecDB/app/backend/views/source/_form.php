<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'source-form',
	'enableAjaxValidation'=>false,
)); ?>
	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'bootlegtypes_id'); ?>
                <?= $form->dropDownList($model, 'bootlegtypes_id', CHtml::listData(Bootlegtype::model()->findAll(), 'id', 'label')); ?>
 		<?php echo $form->error($model,'bootlegtypes_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'label'); ?>
		<?php echo $form->textField($model,'label',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'label'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'shortname'); ?>
		<?php echo $form->textField($model,'shortname',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'shortname'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->