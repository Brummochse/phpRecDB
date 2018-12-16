<?php
$this->beginWidget('booster.widgets.TbPanel', array(
    'title' => 'Change Password for "'.$model->username."'",
    'htmlOptions' => array('class' => 'bootstrap-box-small'),
    'headerButtons' => array(
        array(
            'class' => 'booster.widgets.TbButtonGroup',
            'buttons' => array(
                array('label' => 'View User','buttonType' =>'link', 'url' => array('profile'),'htmlOptions' => array('class'=>'btn-dark'))
            ),
        ),
    )
));
    $form=$this->beginWidget('booster.widgets.TbActiveForm', array('id'=>'user-form'));
        echo $form->passwordFieldGroup($model, 'password');
        $this->widget('booster.widgets.TbButton',array('buttonType' => 'submit', 'label' => $model->isNewRecord ? 'Create' : 'Save', 'context' => 'primary'));
    $this->endWidget();
 $this->endWidget();
