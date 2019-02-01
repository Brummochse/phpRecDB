<?php
echo $form->textFieldGroup($vaModel, 'authorer', array( 'widgetOptions'=>array ('htmlOptions'=>array('maxlength' => 50))));
echo $form->dropDownListGroup($vaModel, 'videoformat_id', array ('widgetOptions'=>array ('htmlOptions' => array('empty'=>'-'),'data'=>CHtml::listData(Videoformat::model()->findAll(), 'id', 'label'))));
echo $form->dropDownListGroup($vaModel, 'aspectratio_id', array ('widgetOptions'=>array ('htmlOptions' => array('empty'=>'-'),'data'=>CHtml::listData(Aspectratio::model()->findAll(), 'id', 'label'))));
echo $form->textFieldGroup($vaModel, 'bitrate', array( 'widgetOptions'=>array ('htmlOptions'=>array('maxlength' => 10))));