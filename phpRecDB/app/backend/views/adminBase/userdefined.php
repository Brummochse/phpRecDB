<?php
$this->beginWidget('booster.widgets.TbPanel', array(
    'title' => 'Set Labels For User Defined Record Information Fields',
    'htmlOptions' => array('class' => 'bootstrap-box-small'),
));

    $form = $this->beginWidget('booster.widgets.TbActiveForm', array(
        'id' => 'inlineForm',
        'type' => 'horizontal',
        'htmlOptions' => array('class' => 'well'),
    ));

        echo $form->textFieldGroup($model, 'userDefined1Label');
        echo $form->textFieldGroup($model, 'userDefined2Label');

        $this->widget('booster.widgets.TbButton', array('buttonType' => 'submit', 'context' => 'primary', 'label' => 'Save'));

     $this->endWidget();
$this->endWidget();


