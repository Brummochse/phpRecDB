<?php
$this->beginWidget('booster.widgets.TbPanel', array(
    'title' => 'Manage Users',
    'htmlOptions' => array('class' => 'bootstrap-box-small'),
));
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
    $this->widget('booster.widgets.TbButton', array('label' => 'Create new User', 'url' => array('create'), 'buttonType' =>'link','context' => 'primary'));
$this->endWidget();