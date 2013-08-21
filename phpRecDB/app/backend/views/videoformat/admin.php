<?php
$this->beginWidget('bootstrap.widgets.TbBox', array(
    'title' => 'Manage Videoformats',
    'htmlOptions' => array('class' => 'bootstrap-box-small'),
));
?>
<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'videoformat-grid',
    'dataProvider' => $model->search(),
    'columns' => array(
        'id',
        'label',
        array(
            'class' => 'CButtonColumn',
            'template' => '{update}{delete}'
        ),
    ),
));
?>
<?php echo CHtml::link('Create new Videoformat', array('create')); ?>
<?php $this->endWidget();?>