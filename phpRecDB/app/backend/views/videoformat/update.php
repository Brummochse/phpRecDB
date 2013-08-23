<?php
$this->beginWidget('bootstrap.widgets.TbBox', array(
    'title' => 'Update Videoformat "'.$model->label."'",
    'htmlOptions' => array('class' => 'bootstrap-box-small'),
    'headerButtons' => array(
        array(
            'class' => 'bootstrap.widgets.TbButtonGroup',
            'type' => 'inverse', 
            'buttons' => array(
                array('label' => 'Manage Videoformats', 'url' => array('admin'))
            ),
        ),
    )
));
?>
<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
<?php $this->endWidget();?>