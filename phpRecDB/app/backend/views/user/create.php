<?php
$this->beginWidget('booster.widgets.TbPanel', array(
    'title' => 'Create User',
    'htmlOptions' => array('class' => 'bootstrap-box-small'),
    'headerButtons' => array(
        array(
            'class' => 'booster.widgets.TbButtonGroup',
            'buttons' => array(
                array('label' => 'Manage Users', 'buttonType' =>'link','url' => array('admin'))
            ),
        ),
    )
));
    echo $this->renderPartial('_form', array('model'=>$model));
$this->endWidget();
