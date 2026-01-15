<?php
	Yii::app()->clientScript->registerCssFile( Yii::app()->getTheme()->getBaseUrl().'/css/undohtml.css');
	Yii::app()->clientScript->registerCssFile( Yii::app()->getTheme()->getBaseUrl().'/css/newway1.css');
	Yii::app()->clientScript->registerCssFile( Yii::app()->getTheme()->getBaseUrl().'/css/RecordView1.css');
	Yii::app()->clientScript->registerCssFile( Yii::app()->getTheme()->getBaseUrl().'/css/artistNav.css');
	Yii::app()->clientScript->registerCssFile( Yii::app()->getTheme()->getBaseUrl().'/css/recordList1.css');
?>
<div id="content" class="contentSize">
    <?php echo $content; ?>
    
</div>
