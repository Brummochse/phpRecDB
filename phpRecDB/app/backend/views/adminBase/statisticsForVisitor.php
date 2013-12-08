<?php

$this->beginWidget('bootstrap.widgets.TbBox', array(
    'title' => 'Last visited records by Visitor with ip: [' . $ip . ']',
    'htmlOptions' => array('class' => 'bootstrap-box-big'),
));

?>

<p>
    <?php
    $this->widget('bootstrap.widgets.TbLabel', array('label' => 'Visitor Ip Address:',));
    echo ' '.$ip;
    ?>
</p>
<p>
    <?php
    $this->widget('bootstrap.widgets.TbLabel', array('label' => 'Try to Lookup IP:',));
    echo ' '.CHtml::link('ip lookup', $ipLookUpUrl);
    ?>
</p>  

<?php

$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider' => $visitedRecords,
    'columns' => array(
        array(
            'name' => 'date',
            'header' => 'visit time'
        ),
        array(
            'name' => 'recordLabel',
            'type' => 'raw',
            'header' => 'visited record'
        ),
        array('class' => 'CButtonColumn',
            'viewButtonUrl' => 'Yii::app()->createUrl("adminEditRecord/updateRecord", array(ParamHelper::PARAM_RECORD_ID=>$data["recordId"]))',
            'template' => '{view}',
        )
    ),
));
?>

<?php $this->endWidget(); ?>

