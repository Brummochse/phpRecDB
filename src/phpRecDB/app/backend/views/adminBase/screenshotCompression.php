<?php
$this->beginWidget('booster.widgets.TbPanel', array(
    'title' => 'Screenshot Compression',
    'htmlOptions' => array('class' => 'bootstrap-box-small'),
));
?>

    <?php
    $form = $this->beginWidget('booster.widgets.TbActiveForm', array(
        'id' => 'inlineForm',
        'type' => 'horizontal',
        'htmlOptions' => array('class' => 'well'),
            ));
    
    echo $form->switchGroup($model, 'value');
    ?>


    <div class="form-actions">
        <?php $this->widget('booster.widgets.TbButton', array('buttonType' => 'submit', 'context' => 'primary', 'label' => 'Save')); ?>
    </div>

    <?php $this->endWidget(); ?>
<?php $this->endWidget();?>