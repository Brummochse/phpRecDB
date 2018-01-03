<?php
$this->beginWidget('booster.widgets.TbPanel', array(
    'title' => 'Manage Media',
    'htmlOptions' => array('class' => 'bootstrap-box-small'),
));
?>

<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'media-grid',
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
<?php echo CHtml::link('Create new Medium', array('create')); ?>

<?php $this->endWidget();?>