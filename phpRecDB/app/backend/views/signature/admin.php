<?php
$this->beginWidget('bootstrap.widgets.TbBox', array(
    'title' => 'Manage Signatures',
    'htmlOptions' => array('class' => 'bootstrap-box-small'),
));
?>

<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'signature-grid',
    'dataProvider' => $model->search(),
    'columns' => array(
        'id',
        'name',
        array(
            'class' => 'CButtonColumn',
            'template' => '{update}{delete}'
        ),
    ),
));
?>

<?php echo CHtml::link('Create new Signature', array('update')); ?>

<?php $this->endWidget();?>