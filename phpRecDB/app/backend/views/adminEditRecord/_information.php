<div class="form">

    <?php
    $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
        'id' => 'record-form',
        'enableAjaxValidation' => false,
            ));
    ?>


    <?php echo $form->errorSummary(array($model, $vaModel)); ?>

    <?php echo $form->hiddenField($model, 'concerts_id'); ?>
    <div id="all">
        <div id="left" class="column">
            <div class="row">
                <?php echo $form->labelEx($model, 'sourceidentification'); ?>
                <?php echo $form->textField($model, 'sourceidentification', array('size' => 50, 'maxlength' => 50)); ?>
                <?php echo $form->error($model, 'sourceidentification'); ?>
            </div>

            <div class="row">
                <?php echo $form->labelEx($model, 'rectypes_id'); ?>
                <?= $form->dropDownList($model, 'rectypes_id', CHtml::listData(Rectype::model()->findAllByAttributes(array('bootlegtypes_id' => $vaId)), 'id', 'label'), Helper::$dropBoxDefaultNullStr); ?>
                <?php echo $form->error($model, 'rectypes_id'); ?>
            </div>

            <div class="row">
                <?php echo $form->labelEx($model, 'sources_id'); ?>
                <?= $form->dropDownList($model, 'sources_id', CHtml::listData(Source::model()->findAllByAttributes(array('bootlegtypes_id' => $vaId)), 'id', 'label'), Helper::$dropBoxDefaultNullStr); ?>
                <?php echo $form->error($model, 'sources_id'); ?>
            </div>

            <div class="row">
                <?php echo $form->labelEx($model, 'sumlength'); ?>
                <?php echo $form->textField($model, 'sumlength', array('size' => 10, 'maxlength' => 10)); ?>
                <?php echo $form->error($model, 'sumlength'); ?>
            </div>

            <div class="row">
                <?php echo $form->labelEx($model, 'media_id'); ?>
                <?= $form->dropDownList($model, 'media_id', CHtml::listData(Medium::model()->findAllByAttributes(array('bootlegtypes_id' => $vaId)), 'id', 'label'), Helper::$dropBoxDefaultNullStr); ?>
                <?php echo $form->error($model, 'media_id'); ?>
            </div>

            <div class="row">
                <?php echo $form->labelEx($model, 'summedia'); ?>
                <?php echo $form->textField($model, 'summedia', array('size' => 10, 'maxlength' => 10)); ?>
                <?php echo $form->error($model, 'summedia'); ?>
            </div>

            <div class="row">
                <?php echo $form->labelEx($model, 'quality'); ?>
                <?php echo $form->dropDownList($model, 'quality',Helper::generateCountedArray(0,10), Helper::$dropBoxDefaultNullStr); ?>
                <?php echo $form->error($model, 'quality'); ?>
            </div>


            <div class="row">
                <?php echo $form->labelEx($model, 'tradestatus_id'); ?>
                <?= $form->dropDownList($model, 'tradestatus_id', CHtml::listData(Tradestatus::model()->findAll(), 'id', 'label'), Helper::$dropBoxDefaultNullStr); ?>
                <?php echo $form->error($model, 'tradestatus_id'); ?>
            </div>

            <div class="row">
                <?php echo $form->labelEx($model, 'taper'); ?>
                <?php echo $form->textField($model, 'taper', array('size' => 50, 'maxlength' => 50)); ?>
                <?php echo $form->error($model, 'taper'); ?>
            </div>

            <div class="row">
                <?php echo $form->labelEx($model, 'transferer'); ?>
                <?php echo $form->textField($model, 'transferer', array('size' => 50, 'maxlength' => 50)); ?>
                <?php echo $form->error($model, 'transferer'); ?>
            </div>

            <div class="row">
                <?php echo $form->labelEx($model, 'visible'); ?>
                <?php echo $form->checkBox($model, 'visible'); ?>
                <?php echo $form->error($model, 'visible'); ?>
            </div>

        </div>
        <div id="middle" class="column">
            <!--  include video OR audio infos -->
            <?php include($vaId == VA::VIDEO ? '_video.php' : '_audio.php'); ?>

        </div>
        <div id="right" class="column">

            <div class="row">
                <?php echo $form->labelEx($model, 'setlist'); ?>
                <?php echo $form->textArea($model, 'setlist', array('rows' => 6, 'cols' => 50)); ?>
                <?php echo $form->error($model, 'setlist'); ?>
            </div>

            <div class="row">
                <?php echo $form->labelEx($model, 'notes'); ?>
                <?php echo $form->textArea($model, 'notes', array('rows' => 6, 'cols' => 50)); ?>
                <?php echo $form->error($model, 'notes'); ?>
            </div>

            <div class="row">
                <?php echo $form->labelEx($model, 'sourcenotes'); ?>
                <?php echo $form->textArea($model, 'sourcenotes', array('rows' => 6, 'cols' => 50)); ?>
                <?php echo $form->error($model, 'sourcenotes'); ?>
            </div>

        </div>
    </div>


    <div class="form-actions">
        <?php $this->widget('bootstrap.widgets.TbButton', array('buttonType' => 'submit', 'type' => 'primary', 'label' => 'save')); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->