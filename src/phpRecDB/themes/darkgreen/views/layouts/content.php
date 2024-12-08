<?php Yii::app()->clientScript->registerCssFile( Yii::app()->getTheme()->getBaseUrl().'/css/contentStyle.css'); ?>
<div id="content" class="contentSize">
    <?php echo $content; ?>
    
</div>
<div style="clear: both;">&nbsp;</div>
<div id="sign" class="contentSize">
Powered by <a href="http://www.phprecdb.com">phpRecDB</a> Version <?= Yii::app()->params['version'] ?>
</div>
