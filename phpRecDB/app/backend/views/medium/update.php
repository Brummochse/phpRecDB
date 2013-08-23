<?php
$this->beginWidget('bootstrap.widgets.TbBox', array(
    'title' => 'Update Medium "'.$model->label."'",
    'htmlOptions' => array('class' => 'bootstrap-box-small'),
    'headerButtons' => array(
        array(
            'class' => 'bootstrap.widgets.TbButtonGroup',
            'type' => 'inverse', 
            'buttons' => array(
                array('label' => 'Manage Aspect-Ratios', 'url' => array('admin'))
            ),
        ),
    )
));
?>
<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
<?php $this->endWidget();?>