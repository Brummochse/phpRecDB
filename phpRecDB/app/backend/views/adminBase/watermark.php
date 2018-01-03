<?php
$this->beginWidget('booster.widgets.TbPanel', array(
    'title' => 'Watermark',

));

?>
<div style="float:left;">
    <?php
    $form = $this->beginWidget('booster.widgets.TbActiveForm', array(
        'id' => 'inlineForm',
        'type' => 'horizontal',
        'htmlOptions' => array('class' => 'well'),
            ));
    ?>

        <?php echo $form->checkBoxGroup($model, 'enable'); ?>
        <?php echo $form->textFieldGroup($model, 'text', array('maxlength' => 255)) ?>
        <?php echo $form->textFieldGroup($model, 'fontSize'); ?>
        <?php echo $form->textFieldGroup($model, 'border', array('maxlength' => 5)); ?>
        <?php echo $form->dropDownListGroup($model, 'align',array('widgetOptions' => array('data' => Helper::parallelArray(WatermarkForm::$ALIGN_ENUM)))); ?>
        <?php echo $form->dropDownListGroup($model, 'valign',array('widgetOptions' => array('data' => Helper::parallelArray(WatermarkForm::$VALIGN_ENUM)))); ?>
        <?php echo $form->dropDownListGroup($model, 'fontStyle',array('widgetOptions' => array('data' => Helper::parallelArray(Yii::app()->screenshotManager->getFonts())))); ?>
        <?php echo $form->colorpickerGroup($model, 'color', array('maxlength' => 7)); ?>
        <?php echo $form->checkBoxGroup($model, 'watermarkThumbnail') ?>
        <?php echo $form->checkBoxGroup($model, 'resizeOnThumbnail') ?>


    <div class="form-actions">
        <?php $this->widget('booster.widgets.TbButton', array('buttonType' => 'submit', 'context' => 'primary', 'label' => 'Save')); ?>
    </div>

    <?php $this->endWidget(); ?>
</div>

<div style="float:left;margin: 5px;">
    <?php if (isset($watermarkScreenshotUrl) && strlen($watermarkScreenshotUrl) > 0) echo CHtml::image($watermarkScreenshotUrl) ?>
</div>

<div style="float:left;margin: 5px;">
    <?php if (isset($watermarkthumbnailUrl) && strlen($watermarkthumbnailUrl) > 0) echo CHtml::image($watermarkthumbnailUrl) ?>
</div>

<?php $this->endWidget(); ?>