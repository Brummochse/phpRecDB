<?php
$this->beginWidget('booster.widgets.TbPanel', array(
    'title' => 'Manage Sources',
    'htmlOptions' => array('class' => 'bootstrap-box-small'),
));
    $this->widget('zii.widgets.grid.CGridView', array(
        'id' => 'source-grid',
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
    $this->widget('booster.widgets.TbButton', array('label' => 'Create', 'url' => array('create'), 'buttonType' =>'link','context' => 'primary'));
$this->endWidget();