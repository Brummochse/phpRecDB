<?php
$this->beginWidget('booster.widgets.TbPanel', array(
    'title' => 'Manage Signatures',
    'htmlOptions' => array('class' => 'bootstrap-box-small'),
));
    $this->widget('zii.widgets.grid.CGridView', array(
        'id' => 'signature-grid',
        'dataProvider' => $model->search(),
        'columns' => array(
            'id',
            'name',
            array(
                'class' => 'CButtonColumn',
                'template' => '{update}{delete}'
            ),
        ),
    ));
    $this->widget('booster.widgets.TbButton', array('label' => 'Create new Signature', 'url' => array('update'), 'buttonType' =>'link','context' => 'primary'));
$this->endWidget();