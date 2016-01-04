<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id' => 'inlineForm',
    'type' => 'horizontal',
        ));
?>

    <?php echo CHtml::errorSummary($model); ?>

    <div class="control-group"><?php echo CHtml::activeLabel($model, 'artist', array('class' => 'control-label')); ?>
        <div class="controls"> 
            <?php $this->widget('zii.widgets.jui.CJuiAutoComplete', array('model' => $model, 'attribute' => 'artist', 'source' => $this->createUrl('suggest/suggestArtist', array('mode' => 'suggest')), 'options' => array('autoFocus' => true, 'minLength' => '0'))); ?>
        </div>
    </div>

    <?php $this->renderPartial('concertForm', array('model' => $model, 'form' => $form)); ?>

    <?php echo $form->radioButtonListRow($model, 'va', array(VA::VIDEO => VA::vaIdToStr(VA::VIDEO), VA::AUDIO => VA::vaIdToStr(VA::AUDIO))); ?>
    <?php echo $form->checkBoxRow($model, 'visible'); ?>

    <div class="form-actions">
        <?php $this->widget('bootstrap.widgets.TbButton', array('buttonType' => 'submit', 'type' => 'primary', 'label' => 'Add Record')); ?>
    </div>

<?php $this->endWidget(); ?>