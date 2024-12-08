<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'venuesdialog',
    'themeUrl' => Yii::app()->getThemeManager()->getBaseUrl(),
    'theme'=>Yii::app()->getTheme()->name,
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
     'cssFile'=>Yii::app()->getTheme()->getBaseUrl() .'/css/recordList.css',
    'pager' => array('cssFile' => Yii::app()->getTheme()->getBaseUrl() .'/css/recordList.css'),
    'columns' => array(
        'name',
        'concerts',
        'records',
    ),
    'id'=>'venues'
));
$this->endWidget('zii.widgets.jui.CJuiDialog');
?>
