<?php
$this->beginWidget('booster.widgets.TbPanel', array(
    'title' => 'List Caching',
    'htmlOptions' => array('class' => 'bootstrap-box-small'),
    'headerButtons' => array(
        Yii::app()->helpCreator->renderModalAndGetHelpBtn($this, 'listCaching')
    )
));
    $form = $this->beginWidget('booster.widgets.TbActiveForm', array(
        'id' => 'inlineForm',
        'type' => 'horizontal',
        'htmlOptions' => array('class' => 'well'),
    ));
        echo $form->switchGroup($model, 'value', array('hint' => '<strong>Maximum Cache Size: </strong>' . (Yii::app()->cache->maxSize / 1024. / 1024.) . " MB"));
        $this->widget('booster.widgets.TbButton', array('buttonType' => 'submit', 'context' => 'primary', 'label' => 'Save'));
    $this->endWidget();
$this->endWidget();