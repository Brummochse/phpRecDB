<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'venuesdialog',
         
    'cssFile' => 'jquery-ui.css',
    'theme' => "css",
    'themeUrl' => Yii::app()->params['wwwUrl'],
    
    'options' => array(
        'title' => 'Most Played Venues',
        'autoOpen' => true,
       'modal' => true,
        'width' => 'auto',
        'close'=>"js:function(){ $(this).dialog('destroy').remove(); }",
        ))
);
$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider' => $venuesData,
    'columns' => array(
        'name',
        'concerts',
        'records',
    ),
    'id'=>'venues'
));
$this->endWidget('zii.widgets.jui.CJuiDialog');
?>
