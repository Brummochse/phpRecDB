<?php
$this->beginWidget('bootstrap.widgets.TbBox', array(
    'title' => 'Manage Tradestatus',
    'htmlOptions' => array('class' => 'bootstrap-box-small'),
));
?>
<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'tradestatus-grid',
    'dataProvider' => $model->search(),
    'columns' => array(
        'id',
        'label',
        'shortname',
        array(
            'class' => 'CButtonColumn',
            'template' => '{update}{delete}'
        ),
    ),
));
?>
<?php echo CHtml::link('Create new Tradestatus', array('create')); ?>
<?php $this->endWidget();?>