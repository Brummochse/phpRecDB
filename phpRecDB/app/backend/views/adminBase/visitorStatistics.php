<?php

$this->beginWidget('booster.widgets.TbPanel', array(
    'title' => 'Last Visitors',
    'htmlOptions' => array('class' => 'bootstrap-box-small'),
    'headerButtons' => array(
        array(
            'class' => 'booster.widgets.TbButtonGroup',
            'buttons' => array(
                array('items' => array(
                        array('label' => 'clear visitor statistics', 'url' => Yii::app()->createUrl('adminBase/clearUserStatistics')),
                        array('label' => 'clear record visit counters', 'url' => Yii::app()->createUrl('adminBase/clearRecordVisitStatistics')),
                    ),'htmlOptions' => array('class'=>'btn-dark')),
            )
        ),
        Yii::app()->helpCreator->renderModalAndGetHelpBtn($this,'visitorStatistics')
    )
));
?>

<?php
        
$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider' => $data,
    'columns' => array(
        array('name' => Terms::IP, 'header' => 'Visitor IP Adress'),
        array('name' => Terms::LAST_VISITED, 'header' => 'Last Visited Time'),
        array('name' => Terms::COUNT, 'header' => 'Visited Pages'),
        array('class' => 'CButtonColumn',
            'viewButtonUrl' => 'Yii::app()->createUrl("adminBase/visitorStatisticsDetail", array(Terms::IP=>$data[Terms::IP]))',
            'template' => '{view}',
        )
    )
));
?>

<?php $this->endWidget(); ?>



