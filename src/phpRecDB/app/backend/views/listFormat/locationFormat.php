<?php
$this->beginWidget('booster.widgets.TbPanel', array(
    'title' => 'List Location Cell Format',
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
        <?php     echo $form->textFieldGroup($model, 'value', array(
                'size' => 60,
                'maxlength' => 255,
                'hint' => 'available placeholders: {country}, {city}, {venue}, {supplement}'
        )); ?>
    </fieldset>
    <div class="form-actions">
        <?php $this->widget('booster.widgets.TbButton', array('buttonType' => 'submit', 'context' => 'primary', 'label' => 'Save')); ?>
    </div>

    <?php $this->endWidget(); ?>
<?php $this->endWidget();?>


