<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'artistsdialog',
         
    'cssFile' => 'jquery-ui.css',
    'theme' => "css",
    'themeUrl' => Yii::app()->params['wwwUrl'],
    
    'options' => array(
        'title' => 'Most Common Artists',
        'autoOpen' => true,
        'modal' => true,
        'width' => 'auto',
        'close'=>"js:function(){ $(this).dialog('destroy').remove(); }",
        ))
);
$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider' => $artistsData,
    'columns' => array(
        'name',
        'concerts',
        'records',
        array(
            'name' => 'length',
            'type' => 'raw',
            'value' => 'CHtml::encode($data["length"]." min (".number_format(($data["length"]/60),2)." hour)")',
        ),
    ),
    'id'=>'artists'
));
$this->endWidget('zii.widgets.jui.CJuiDialog');
?>