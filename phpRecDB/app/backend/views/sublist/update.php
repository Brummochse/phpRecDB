<?php

$this->beginWidget('bootstrap.widgets.TbBox', array(
    'title' => 'Update Sublist "' . $model->label.'"',
    'htmlOptions' => array('class' => 'bootstrap-box-small'),
    'headerButtons' => array(
        array(
            'class' => 'bootstrap.widgets.TbButtonGroup',
            'buttons' => array(
                array('label' => 'Manage Sublists', 'url' => array('admin'))
            ),
        ),
    )
));
?>
<?php echo $this->renderPartial('_form', array('model' => $model)); ?>
<?php $this->endWidget(); ?>