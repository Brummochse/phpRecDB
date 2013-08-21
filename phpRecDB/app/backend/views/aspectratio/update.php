<?php
$this->beginWidget('bootstrap.widgets.TbBox', array(
    'title' => 'Update Aspect-Ratio "'.$model->label."'",
    'htmlOptions' => array('class' => 'bootstrap-box-small'),
    'headerButtons' => array(
        array(
            'class' => 'bootstrap.widgets.TbButtonGroup',
            'buttons' => array(
                array('label' => 'Manage Aspect-Ratios', 'url' => array('admin'))
            ),
        ),
    )
));
?>
<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
<?php $this->endWidget();?>