<?php
$this->beginWidget('booster.widgets.TbPanel', array(
    'title' =>$model->isNewRecord ? 'Create Aspect-Ratio' : 'Update Aspect-Ratio "' . $model->label . '"',
    'htmlOptions' => array('class' => 'bootstrap-box-small'),
    'headerButtons' => array(
        array(
            'class' => 'booster.widgets.TbButtonGroup',
            'buttons' => array(
                array('label' => 'Manage Aspect-Ratios', 'buttonType' =>'link', 'url' => array('admin'),'htmlOptions' => array('class'=>'btn-dark'))
            ),
        ),
    )
));
    $form=$this->beginWidget('booster.widgets.TbActiveForm', array(	'id'=>'aspectratio-form'));
        echo $form->textFieldGroup($model,'label');
        $this->widget('booster.widgets.TbButton',array('buttonType' => 'submit', 'label' => $model->isNewRecord ? 'Create' : 'Save','context'=>'primary'));
    $this->endWidget();
$this->endWidget();