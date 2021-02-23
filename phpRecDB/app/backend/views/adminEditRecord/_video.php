<?php
echo $form->textFieldGroup($vaModel, 'authorer', array('widgetOptions' => array('htmlOptions' => array('maxlength' => 50))));
echo $form->dropDownListGroup($vaModel, 'videoformat_id', array('widgetOptions' => array('htmlOptions' => array('empty' => '-'), 'data' => CHtml::listData(Videoformat::model()->findAll(), 'id', 'label'))));
echo $form->dropDownListGroup($vaModel, 'aspectratio_id', array('widgetOptions' => array('htmlOptions' => array('empty' => '-'), 'data' => CHtml::listData(Aspectratio::model()->findAll(), 'id', 'label'))));
echo $form->textFieldGroup($vaModel, 'bitrate', array('widgetOptions' => array('htmlOptions' => array('maxlength' => 10))));
echo $form->textFieldGroup($vaModel, 'width');
echo $form->textFieldGroup($vaModel, 'height');

?>

<div class="form-group row">
    <div class="col-sm-3"><?php echo CHtml::activeLabel($vaModel, 'menu'); ?></div>
    <div class="col-sm-3"><?php echo $form->checkBox($vaModel, 'menu'); ?></div>
</div>
<div class="form-group row">
    <div class="col-sm-3"><?php echo CHtml::activeLabel($vaModel, 'chapters'); ?></div>
    <div class="col-sm-3"><?php echo $form->checkBox($vaModel, 'chapters'); ?></div>
</div>