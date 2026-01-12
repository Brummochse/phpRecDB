<?php
$this->beginWidget('booster.widgets.TbPanel', array(
    'title' => 'Manage Sublists',
    'htmlOptions' => array('class' => 'bootstrap-box-small'),
));
    $this->widget('zii.widgets.grid.CGridView', array(
        'id' => 'sublist-grid',
        'dataProvider' => $model->search(),
        'columns' => array(
            'id',
            'label',
            array(
                'name' => 'exclude from global list',
                'type' => 'boolean',
                'value' => '$data->exclude',
            ),
            array(
                'class' => 'CButtonColumn',
                'template' => '{update}{delete}'
            ),
        ),
    ));
    $this->widget('booster.widgets.TbButton', array('label' => 'Create new Sublist', 'url' => array('create'), 'buttonType' =>'link','context' => 'primary'));
$this->endWidget();
