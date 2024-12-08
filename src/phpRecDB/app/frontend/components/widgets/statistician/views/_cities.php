<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'citiesdialog',
     
    'cssFile' => 'jquery-ui.css',
    'theme' => "css",
    'themeUrl' => Yii::app()->params['wwwUrl'],
    
    'options' => array(
        'title' => 'Most Played Cities',
        'autoOpen' => true,
        'modal' => true,
        'width' => 'auto',
        'close'=>"js:function(){ $(this).dialog('destroy').remove(); }",
        ))
);
$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider' => $citiesData,
    'columns' => array(
        'name',
        'concerts',
        'records',
    ),
    'id'=>'cities'
));
$this->endWidget('zii.widgets.jui.CJuiDialog');
?>
