<?php
$this->beginWidget('booster.widgets.TbPanel', array(
    'title' => 'Manage Videoformats',
    'htmlOptions' => array('class' => 'bootstrap-box-small'),
));
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
    $this->widget('booster.widgets.TbButton', array('label' => 'Create', 'url' => array('create'), 'buttonType' =>'link','context' => 'primary'));
$this->endWidget();