<?php
$this->beginWidget('booster.widgets.TbPanel', array(
    'title' => 'Create Source',
    'htmlOptions' => array('class' => 'bootstrap-box-small'),
    'headerButtons' => array(
        array(
            'class' => 'booster.widgets.TbButtonGroup',
            'context' => 'inverse',
            'buttons' => array(
                array('label' => 'Manage Sources', 'url' => array('admin'))
            ),
        ),
    )
));
?>
<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
<?php $this->endWidget();?>