<?php
$form = $this->beginWidget('booster.widgets.TbActiveForm', array(
    'id' => 'inlineForm',
    'type' => 'horizontal',
    'action' => Yii::app()->createUrl('signature/update', array('id' => $model->id)),
    'htmlOptions' => array('class' => 'well'),
));
    echo $form->textFieldGroup($model, 'name', array('size' => 60, 'maxlength' => 255));
    echo $form->checkBoxGroup($model, 'enabled');
    echo $form->textFieldGroup($model, 'additionalText', array('size' => 60, 'maxlength' => 255));
    echo $form->dropDownListGroup($model, 'fontSize', array('widgetOptions' => array('data' => Helper::generateCountedArray(5, 20))));
    echo $form->dropDownListGroup($model, 'recordsCount', array('widgetOptions' => array('data' => Helper::generateCountedArray(1, 20))));
    echo $form->checkBoxGroup($model, 'bgTransparent');
    echo $form->colorpickerGroup($model, 'bgColor', array('size' => 7, 'maxlength' => 7));
    echo $form->colorpickerGroup($model, 'color1', array('size' => 7, 'maxlength' => 7));
    echo $form->colorpickerGroup($model, 'color2', array('size' => 7, 'maxlength' => 7));
    echo $form->colorpickerGroup($model, 'color3', array('size' => 7, 'maxlength' => 7));
    echo $form->dropDownListGroup($model, 'quality', array('widgetOptions' => array('data' => Helper::generateCountedArray(0, 9))));
    $this->widget('booster.widgets.TbButton', array('buttonType' => 'submit', 'context' => 'primary', 'label' => $model->isNewRecord ? 'Create' : 'Save'));
$this->endWidget();
