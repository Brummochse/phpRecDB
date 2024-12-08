<div class="form">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'screenshot-form',
        'enableAjaxValidation' => false,
        'htmlOptions' => array('enctype' => 'multipart/form-data'),
            ));
    ?>

    <?php echo $form->errorSummary($screenshotModel); ?>

    <div class="row">
        <?php echo $form->hiddenField($screenshotModel, 'video_recordings_id'); //only as workaround, because $_POST['Screenshot'] is empty without it ?>
    </div>


    <div class="row">
        <?php
        $this->widget('CMultiFileUpload', array(
            'name' => 'screenshots',
            'accept' => 'jpeg|jpg|gif|png|bmp', 
            'duplicate' => 'Duplicate file!', 
            'denied' => 'Invalid file type',
            'remove' => Yii::t('ui', 'Remove'),
        ));
        ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton('Upload'); ?>
    </div>

    <?php $this->endWidget(); ?>
</div><!-- form -->
<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider' => $dataProvider,
    'enableSorting' => false,
    'id' => 'screenshot-grid',
    'columns' => array(
        array(
            'header' => 'screenshot',
            'type' => 'raw',
            'value' => 'CHtml::image(Yii::app()->params["screenshotsUrl"]."/".$data->thumbnail)',
        ),
        'screenshot_filename',
        'thumbnail',
        //'order_id',
        array(
            'header' => 'upload date',
            'type' => 'raw',
            'value' => array($this, 'getScreenshotUploadDate'),
        ),
        array(
            'class' => 'CButtonColumn',
            'template' => '{up} {down} {delete}',
            'deleteButtonUrl' => 'Yii::app()->createUrl(\'adminEditRecord/deleteScreenshot\', array (ParamHelper::PARAM_SCREENSHOT_ID => $data->id))',
            'buttons' => array(
                'up' => array(
                    'label' => 'move up',
                    'imageUrl' => Yii::app()->params['wwwUrl'] . '/images/move_up.png',
                    'url' => 'Yii::app()->createUrl(\'adminEditRecord/moveUpScreenshot\', array (ParamHelper::PARAM_SCREENSHOT_ID => $data->id))',
                    'options' => array('ajax' => array('type' => 'post', 'url' => 'js:$(this).attr("href")', 'success' => 'js:function(data) { $.fn.yiiGridView.update("screenshot-grid")}'))
                ),
                'down' => array(
                    'label' => 'move down',
                    'imageUrl' => Yii::app()->params['wwwUrl'] . '/images/move_down.png',
                    'url' => 'Yii::app()->createUrl(\'adminEditRecord/moveDownScreenshot\', array (ParamHelper::PARAM_SCREENSHOT_ID => $data->id))',
                    'options' => array('ajax' => array('type' => 'post', 'url' => 'js:$(this).attr("href")', 'success' => 'js:function(data) { $.fn.yiiGridView.update("screenshot-grid")}'))
                ),
            ),
        ),
    ),
));
?>
