<div class="form">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'youtube-form',
        'enableAjaxValidation' => false,
            ));
    
    ?>

    <?php echo $form->errorSummary($youtubeFormModel); ?>

    <div class="row">
        <?php echo $form->labelEx($youtubeFormModel, 'title'); ?>
        <?php echo $form->textField($youtubeFormModel, 'title', array('maxlength' => 255)); ?>
        <?php echo $form->error($youtubeFormModel, 'title'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($youtubeFormModel, 'youtubeUrl'); ?>
        <?php echo $form->textField($youtubeFormModel, 'youtubeUrl', array('maxlength' => 255)); ?>
        <?php echo $form->error($youtubeFormModel, 'youtubeUrl'); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton('Create'); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->


<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider' => $dataProvider,
    'id' => 'youtube-grid',
    'columns' => array(
        'title',
        array(
            'name' => 'youtubeId',
            'header' => 'Youtube ID',
        ),
        array(
            'name' => 'youtube',
            'type' => 'raw',
            'header' => 'Youtube Video',
            'value' => array($this, 'renderYoutube'),
        ),
        'order_id',
        array(
            'class' => 'CButtonColumn',
            'template' => '{up} {down} {delete}',
            'deleteButtonUrl' => 'Yii::app()->createUrl("adminEditRecord/deleteYoutube", array (ParamHelper::PARAM_YOUTUBE_ID => $data->id))',
            'buttons' => array(
                'up' => array(
                    'label' => 'move up',
                    'imageUrl' => Yii::app()->params['wwwUrl'] . '/images/move_up.png',
                    'url' => 'Yii::app()->createUrl("adminEditRecord/moveUpYoutube", array (ParamHelper::PARAM_YOUTUBE_ID => $data->id))',
                    'options' => array('ajax' => array('type' => 'post', 'url' => 'js:$(this).attr("href")', 'success' => 'js:function(data) { $.fn.yiiGridView.update("youtube-grid")}'))
                ),
                'down' => array(
                    'label' => 'move down',
                    'imageUrl' => Yii::app()->params['wwwUrl'] . '/images/move_down.png',
                    'url' => 'Yii::app()->createUrl("adminEditRecord/moveDownYoutube", array (ParamHelper::PARAM_YOUTUBE_ID => $data->id))',
                    'options' => array('ajax' => array('type' => 'post', 'url' => 'js:$(this).attr("href")', 'success' => 'js:function(data) { $.fn.yiiGridView.update("youtube-grid")}'))
                ),
            ),
        ),
    ),
    'enableSorting' => false,
));
?>
