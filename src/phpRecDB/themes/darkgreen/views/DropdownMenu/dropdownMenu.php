<div class="panel">
    <?php
    $this->widget('MbMenu', array(
        'items'=>$items,
                'cssFile' => Yii::app()->getTheme()->getBaseUrl() . '/css/artistMenu.css',
    ));
?>
</div>