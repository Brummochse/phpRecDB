<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'countriesdialog',
         
    'cssFile' => 'jquery-ui.css',
    'theme' => "css",
    'themeUrl' => Yii::app()->params['wwwUrl'],
    
    'options' => array(
        'title' => 'Most Played Countries',
        'autoOpen' => true,
        'modal' => true,
        'width' => 'auto',
        'close'=>"js:function(){ $(this).dialog('destroy').remove(); }",
        ))
);
$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider' => $countriesData,
    'columns' => array(
        'name',
        'concerts',
        'records',
    ),
    'id'=>'countries'
));
$this->endWidget('zii.widgets.jui.CJuiDialog');
?>
