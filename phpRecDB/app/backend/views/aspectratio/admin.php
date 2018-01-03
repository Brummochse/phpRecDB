<?php
$this->beginWidget('booster.widgets.TbPanel', array(
    'title' => 'Manage Aspect-Ratios',
    'htmlOptions' => array('class' => 'bootstrap-box-small'),
));
?>

<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'aspectratio-grid',
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
<?php echo CHtml::link('Create new Aspectratio', array('create')); ?>
<?php $this->endWidget();?>