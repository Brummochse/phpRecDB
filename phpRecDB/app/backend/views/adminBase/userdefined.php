<?php
$this->beginWidget('booster.widgets.TbPanel', array(
    'title' => 'Set Labels For User Defined Record Information Fields',
    'htmlOptions' => array('class' => 'bootstrap-box-small'),
));
?>

    <?php
    $form = $this->beginWidget('booster.widgets.TbActiveForm', array(
        'id' => 'inlineForm',
        'type' => 'horizontal',
        'htmlOptions' => array('class' => 'well'),
            ));
    ?>
    <fieldset>
        <?php echo $form->textFieldGroup($model, 'userDefined1Label', array('maxlength' => 255)) ?>
        <?php echo $form->textFieldGroup($model, 'userDefined2Label', array('maxlength' => 255)) ?>
    </fieldset>

    <div class="form-actions">
        <?php $this->widget('booster.widgets.TbButton', array('buttonType' => 'submit', 'type' => 'primary', 'label' => 'Save')); ?>
    </div>

    <?php $this->endWidget(); ?>
<?php $this->endWidget();?>


