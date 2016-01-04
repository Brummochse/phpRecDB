<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id' => 'inlineForm',
    'type' => 'horizontal',
        ));
?>

    <?php echo $form->textAreaRow($model, 'text'); ?>
    <?php echo $form->fileFieldRow($model, 'file'); ?>
    <?php echo $form->checkBoxRow($model, 'visible'); ?>

    <?php //echo $form->checkBoxRow(null, 'visible');  ?>
    <div class="form-actions">
        <?php $this->widget('bootstrap.widgets.TbButton', array('buttonType' => 'submit', 'type' => 'primary', 'label' => 'Add Record')); ?>
    </div>

<?php $this->endWidget(); ?>