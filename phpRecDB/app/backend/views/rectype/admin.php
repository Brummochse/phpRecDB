<?php
$this->beginWidget('bootstrap.widgets.TbBox', array(
    'title' => 'Manage Record-Types',
    'htmlOptions' => array('class' => 'bootstrap-box-small'),
));
?>

<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'rectype-grid',
    'dataProvider' => $model->search(),
    'columns' => array(
        'id',
        array(
            'name' => 'Bootleg Type',
            'value' => 'CHtml::encode(Bootlegtype::model()->findByPk($data["bootlegtypes_id"])->label)',
        ),
        'label',
        'shortname',
        array(
            'class' => 'CButtonColumn',
            'template' => '{update}{delete}'
        ),
    ),
));
?>
<?php echo CHtml::link('Create new Rectype', array('create')); ?>
<?php $this->endWidget();?>