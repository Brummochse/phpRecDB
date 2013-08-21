
<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id' => 'inlineForm',
    'type' => 'horizontal',
    'action' => Yii::app()->createUrl('signature/update', array('id' => $model->id)),
    'htmlOptions' => array('class' => 'well'),
        ));
?>
<fieldset>

    <?php echo $form->textFieldRow($model, 'name', array('size' => 60, 'maxlength' => 255)); ?>
    <?php echo $form->checkBoxRow($model, 'enabled'); ?>
    <?php echo $form->textFieldRow($model, 'additionalText', array('size' => 60, 'maxlength' => 255)); ?>
    <?php echo $form->dropDownListRow($model, 'recordsCount',Helper::generateCountedArray(1,20)); ?>    
    <?php echo $form->checkBoxRow($model, 'bgTransparent'); ?>
    <?php echo $form->colorpickerRow($model, 'bgColor', array('size' => 7, 'maxlength' => 7)); ?>
    <?php echo $form->colorpickerRow($model, 'color1', array('size' => 7, 'maxlength' => 7)); ?>
    <?php echo $form->colorpickerRow($model, 'color2', array('size' => 7, 'maxlength' => 7)); ?>
    <?php echo $form->colorpickerRow($model, 'color3', array('size' => 7, 'maxlength' => 7)); ?>
    <?php echo $form->dropDownListRow($model, 'quality',  Helper::generateCountedArray(0,9)); ?>
    

</fieldset>

<div class="form-actions">
    <?php $this->widget('bootstrap.widgets.TbButton', array('buttonType' => 'submit', 'type' => 'primary', 'label' => $model->isNewRecord ? 'Create' : 'Save')); ?>
</div>

<?php $this->endWidget(); ?>
