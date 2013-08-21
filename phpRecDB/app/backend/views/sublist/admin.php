<?php
$this->beginWidget('bootstrap.widgets.TbBox', array(
    'title' => 'Manage Sublists',
    'htmlOptions' => array('class' => 'bootstrap-box-small'),
));
?>

<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'sublist-grid',
    'dataProvider' => $model->search(),
    'ajaxUpdate' => false, //to update sublist menu points
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
<?php echo CHtml::link('Create new Sublist', array('create')); ?>

<?php $this->endWidget();?>
