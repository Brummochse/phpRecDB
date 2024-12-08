<?php
$form = $this->beginWidget('booster.widgets.TbActiveForm', array(
    'id' => 'inlineForm',
    'type' => 'horizontal',
        ));
?>

    <?php echo CHtml::errorSummary($model); ?>

    <div class="form-group"><?php echo CHtml::activeLabel($model, 'artist', array('class' => 'control-label col-sm-3')); ?>
        <div class="col-sm-9">
            <?php $this->widget('zii.widgets.jui.CJuiAutoComplete', array('htmlOptions'=>array('class'=>'form-control','placeholder'=>'Artist'),'model' => $model, 'attribute' => 'artist', 'source' => $this->createUrl('suggest/suggestArtist', array('mode' => 'suggest')), 'options' => array('autoFocus' => true, 'minLength' => '0'))); ?>
        </div>
    </div>

    <?php $this->renderPartial('concertForm', array('model' => $model, 'form' => $form)); ?>

    <?php echo $form->radioButtonListGroup($model, 'va',array ('widgetOptions'=>array ('data'=>array(VA::VIDEO => VA::vaIdToStr(VA::VIDEO), VA::AUDIO => VA::vaIdToStr(VA::AUDIO))))); ?>
    <?php echo $form->checkBoxGroup($model, 'visible'); ?>

    <div class="form-actions">
        <?php $this->widget('booster.widgets.TbButton', array('buttonType' => 'submit', 'context' => 'primary', 'label' => 'Add Record')); ?>
    </div>

<?php $this->endWidget(); ?>