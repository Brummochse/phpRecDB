<?php
$this->beginWidget('booster.widgets.TbPanel', array(
    'title' =>$model->isNewRecord ? 'Create Medium' : 'Update Medium "' . $model->label . '"',
    'htmlOptions' => array('class' => 'bootstrap-box-small'),
    'headerButtons' => array(
        array(
            'class' => 'booster.widgets.TbButtonGroup',
            'buttons' => array(
                array('label' => 'Manage Media','buttonType' =>'link','url' => array('admin'),'htmlOptions' => array('class'=>'btn-dark'))
            ),
        ),
    )
));
    $form=$this->beginWidget('booster.widgets.TbActiveForm', array('id'=>'media-form'));
        echo $form->dropDownListGroup($model, 'bootlegtypes_id', array('widgetOptions' => array('data' =>CHtml::listData(Bootlegtype::model()->findAll(), 'id', 'label'))));
        echo $form->textFieldGroup($model,'label');
        echo $form->textFieldGroup($model,'shortname');
        $this->widget('booster.widgets.TbButton',array('buttonType' => 'submit', 'label' => $model->isNewRecord ? 'Create' : 'Save','context'=>'primary'));
    $this->endWidget();
$this->endWidget();