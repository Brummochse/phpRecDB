<?php
$this->beginWidget('booster.widgets.TbPanel', array(
    'title' =>$model->isNewRecord ? 'Create Tradestatus' : 'Update Tradestatus "' . $model->label . '"',
    'htmlOptions' => array('class' => 'bootstrap-box-small'),
    'headerButtons' => array(
        array(
            'class' => 'booster.widgets.TbButtonGroup',
            'buttons' => array(
                array('label' => 'Manage Tradestatus','buttonType' =>'link', 'url' => array('admin'),'htmlOptions' => array('class'=>'btn-dark'))
            ),
        ),
    )
));
    $form=$this->beginWidget('booster.widgets.TbActiveForm', array('id'=>'tradestatus-form'));
        echo $form->textFieldGroup($model,'label');
        echo $form->textFieldGroup($model,'shortname');
        $this->widget('booster.widgets.TbButton',array('buttonType' => 'submit', 'label' => $model->isNewRecord ? 'Create' : 'Save','context'=>'primary'));
    $this->endWidget();
$this->endWidget();?>