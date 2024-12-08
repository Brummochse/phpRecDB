<?php
$this->beginWidget('booster.widgets.TbPanel', array(
    'title' => 'Choose Frontend Theme',
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
        <?php echo $form->dropDownListGroup($model, 'value',array('widgetOptions' => array('data' => Helper::parallelArray(Yii::app()->themeManager->themeNames)))); ?>
    </fieldset>
    <div class="form-actions">
        <?php $this->widget('booster.widgets.TbButton', array('buttonType' => 'submit', 'context' => 'primary', 'label' => 'Save')); ?>
    </div>

    <?php $this->endWidget(); ?>
<?php $this->endWidget();?>


