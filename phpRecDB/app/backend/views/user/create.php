<?php
$this->beginWidget('bootstrap.widgets.TbBox', array(
    'title' => 'Create User',
    'htmlOptions' => array('class' => 'bootstrap-box-small'),
    'headerButtons' => array(
        array(
            'class' => 'bootstrap.widgets.TbButtonGroup',
            'type' => 'inverse', 
            'buttons' => array(
                array('label' => 'Manage Users', 'url' => array('admin'))
            ),
        ),
    )
));
?>
<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
<?php $this->endWidget();?>