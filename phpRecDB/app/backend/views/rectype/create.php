<?php
$this->beginWidget('booster.widgets.TbPanel', array(
    'title' => 'Create Record-Type',
    'htmlOptions' => array('class' => 'bootstrap-box-small'),
    'headerButtons' => array(
        array(
            'class' => 'booster.widgets.TbButtonGroup',
            'context' => 'inverse',
            'buttons' => array(
                array('label' => 'Manage Record-Types', 'url' => array('admin'))
            ),
        ),
    )
));
?>
<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
<?php $this->endWidget();?>