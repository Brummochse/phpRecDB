<?php
$form = $this->beginWidget('booster.widgets.TbActiveForm', array(
    'id' => 'inlineForm',
    'type' => 'horizontal',
        ));
?>

    <?php echo $form->textAreaGroup($model, 'text'); ?>
    <?php echo $form->fileFieldGroup($model, 'file'); ?>
    <?php echo $form->checkBoxGroup($model, 'visible'); ?>

    <div class="form-actions">
        <?php $this->widget('booster.widgets.TbButton', array('buttonType' => 'submit', 'context' => 'primary', 'label' => 'Add Record')); ?>
    </div>

<?php $this->endWidget(); ?>