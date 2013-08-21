<?php
$this->beginWidget('bootstrap.widgets.TbBox', array(
    'title' => 'Manage Users',
    'htmlOptions' => array('class' => 'bootstrap-box-small'),
));
?>
<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'user-grid',
    'dataProvider' => $model->search(),
    'columns' => array(
        'id',
        'username',
        'role',
        array(
            'class' => 'CButtonColumn',
            'template' => '{update}{delete}'
        ),
    ),
));
?>
<?php echo CHtml::link('Create new User', array('create')); ?>
<?php $this->endWidget();?>