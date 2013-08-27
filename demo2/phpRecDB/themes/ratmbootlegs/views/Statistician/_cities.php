<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'citiesdialog',
    'themeUrl' => Yii::app()->getThemeManager()->getBaseUrl(),
    'theme'=>Yii::app()->getTheme()->name,
    'options' => array(
        'title' => 'Most Played Cities',
        'autoOpen' => true,
       'modal' => true,
        'width' => 'auto',
        'close'=>"js:function(){ $(this).dialog('destroy').remove(); }",
        ))
);?>
<div class="contentSize">
<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider' => $citiesData,
     'cssFile'=>Yii::app()->getTheme()->getBaseUrl() .'/css/recordList.css',
    'pager' => array('cssFile' => Yii::app()->getTheme()->getBaseUrl() .'/css/recordList.css'),
    'columns' => array(
        'name',
        'concerts',
        'records',
    ),
    'id'=>'cities'
));?>
 </div>   
<?php $this->endWidget('zii.widgets.jui.CJuiDialog');
?>