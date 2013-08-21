
<div style="float:left;">
    <?php
    $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
        'id' => 'inlineForm',
        'type' => 'horizontal',
        'htmlOptions' => array('class' => 'well'),
            ));
    ?>
    <fieldset>

        <?php echo $form->checkBoxRow($model, 'enable'); ?>
        <?php echo $form->textFieldRow($model, 'text', array('maxlength' => 255)) ?>
        <?php echo $form->textFieldRow($model, 'fontSize'); ?>
        <?php echo $form->textFieldRow($model, 'border', array('maxlength' => 5)); ?>
        <?php echo $form->dropDownListRow($model, 'align', Helper::parallelArray(WatermarkForm::$ALIGN_ENUM)); ?>
        <?php echo $form->dropDownListRow($model, 'valign', Helper::parallelArray(WatermarkForm::$VALIGN_ENUM)); ?>
        <?php echo $form->dropDownListRow($model, 'fontStyle', Helper::parallelArray(Yii::app()->screenshotManager->getFonts())); ?>
        <?php echo $form->colorpickerRow($model, 'color', array('maxlength' => 7)); ?>
        <?php echo $form->checkBoxRow($model, 'watermarkThumbnail') ?>
        <?php echo $form->checkBoxRow($model, 'resizeOnThumbnail') ?>


    </fieldset>

    <div class="form-actions">
        <?php $this->widget('bootstrap.widgets.TbButton', array('buttonType' => 'submit', 'type' => 'primary', 'label' => 'Save')); ?>
    </div>

    <?php $this->endWidget(); ?>
</div>

<div >
<?php if (isset($watermarkScreenshotUrl) && strlen($watermarkScreenshotUrl) > 0) echo CHtml::image($watermarkScreenshotUrl) ?>
    <br>
    <?php if (isset($watermarkthumbnailUrl) && strlen($watermarkthumbnailUrl) > 0) echo CHtml::image($watermarkthumbnailUrl) ?>
</div>


