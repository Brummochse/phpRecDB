<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'artistsdialog',
    'themeUrl' => Yii::app()->getThemeManager()->getBaseUrl(),
    'theme'=>Yii::app()->getTheme()->name,
    'options' => array(
        'autoOpen' => true,
        'title' => 'Most Common Artists',
        'modal' => true,
        'width' => 'auto',
        'close'=>"js:function(){ $(this).dialog('destroy').remove(); }",
        ))
);?>
<div class="contentSize">
<?php $this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider' => $artistsData,
    'cssFile'=>Yii::app()->getTheme()->getBaseUrl() .'/css/recordList.css',
    'pager' => array('cssFile' => Yii::app()->getTheme()->getBaseUrl() .'/css/recordList.css'),
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
));?>
 </div>   
<?php $this->endWidget('zii.widgets.jui.CJuiDialog');
?>
