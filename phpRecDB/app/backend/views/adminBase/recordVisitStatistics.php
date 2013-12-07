<?php

$this->beginWidget('bootstrap.widgets.TbBox', array(
    'title' => 'Last Record Visitors',
    'htmlOptions' => array('class' => 'bootstrap-box-small'),
));
?>

<?php

$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider' => $data,
    'columns' => array(
        array('name' => Terms::IP, 'header' => 'Visitor IP Adress'),
        array('name' => Terms::LAST_VISITED, 'header' => 'Last Visited Time'),
        array('name' => Terms::COUNT, 'header' => 'Visited Records'),
        array('class' => 'CButtonColumn',
           'viewButtonUrl' => 'Yii::app()->createUrl("adminBase/statisticForVisitor", array(Terms::IP=>$data[Terms::IP]))',
            'template'=>'{view}',
            
            
            )
    )
));
?>

<?php $this->endWidget(); ?>





