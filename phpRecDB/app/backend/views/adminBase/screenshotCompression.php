<?php
$this->beginWidget('bootstrap.widgets.TbBox', array(
    'title' => 'Screenshot Compression',
    'htmlOptions' => array('class' => 'bootstrap-box-small'),
));
?>

    <?php
    $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
        'id' => 'inlineForm',
        'type' => 'horizontal',
        'htmlOptions' => array('class' => 'well'),
            ));
    ?>
    <fieldset>
        <?php echo $form->checkBoxRow($model, 'enable_compression'); ?>
    </fieldset>

    <div class="form-actions">
        <?php $this->widget('bootstrap.widgets.TbButton', array('buttonType' => 'submit', 'type' => 'primary', 'label' => 'Save')); ?>
    </div>

    <?php $this->endWidget(); ?>
<?php $this->endWidget();?>