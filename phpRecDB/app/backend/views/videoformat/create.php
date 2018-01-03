<?php
$this->beginWidget('booster.widgets.TbPanel', array(
    'title' => 'Create Videoformat',
    'htmlOptions' => array('class' => 'bootstrap-box-small'),
    'headerButtons' => array(
        array(
            'class' => 'booster.widgets.TbButtonGroup',
            'context' => 'inverse', 
            'buttons' => array(
                array('label' => 'Manage Videoformats', 'url' => array('admin'))
            ),
        ),
    )
));
?>
<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
<?php $this->endWidget();?>