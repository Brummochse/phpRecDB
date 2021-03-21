<div class="form">
    <style>
        .col-sm-3,
        .col-md-5,
        .col-md-7,
        .col-md-6 {
            padding-left: 0px !important;
        }
    </style>
    <?php
    $form = $this->beginWidget('booster.widgets.TbActiveForm', array(
        'id' => 'record-form',
        'enableAjaxValidation' => false,
    ));
    ?>

    <?php echo $form->errorSummary(array($model, $vaModel)); ?>

    <?php echo $form->hiddenField($model, 'concerts_id'); ?>
    <div id="all">
        <div id="left" class="column">
            <?php
            echo $form->textFieldGroup($model, 'sourceidentification', array('widgetOptions' => array('htmlOptions' => array('maxlength' => 255))));
            echo $form->dropDownListGroup($model, 'rectypes_id', array('widgetOptions' => array('htmlOptions' => array('empty'=>'-'),'data' => CHtml::listData(Rectype::model()->findAllByAttributes(array('bootlegtypes_id' => $vaId)), 'id', 'label'))));
            echo $form->dropDownListGroup($model, 'sources_id', array('widgetOptions' => array('htmlOptions' => array('empty'=>'-'),'data' => CHtml::listData(Source::model()->findAllByAttributes(array('bootlegtypes_id' => $vaId)), 'id', 'label'))));
            ?>

            <div class="form-row">
                <div class="form-group col-md-5">
                    <?php echo CHtml::activeLabel($model, 'sumlength'); ?>
                    <?= $form->textField($model, 'sumlength', array('maxlength' => 10,'class'=>'form-control')); ?>
                </div>
                <div class="form-group col-md-7">
                    <?php echo CHtml::activeLabel($model, 'size'); ?>
                    <?= $form->textField($model, 'size', array('maxlength' => 10,'class'=>'form-control')); ?>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-5">
                    <?php echo CHtml::activeLabel($model, 'summedia'); ?>
                    <?= $form->textField($model, 'summedia', array('maxlength' => 10,'class'=>'form-control')); ?>
                </div>
                <div class="form-group col-md-7">
                    <?php echo CHtml::activeLabel($model, 'media_id'); ?>
                    <?= $form->dropDownList($model, 'media_id', CHtml::listData(Medium::model()->findAllByAttributes(array('bootlegtypes_id' => $vaId)), 'id', 'label'), array('empty' => '-','class'=>'form-control')); ?>
                </div>
            </div>

            <?php
            echo $form->textFieldGroup($model, 'codec');
            echo $form->dropDownListGroup($model, 'quality', array('widgetOptions' => array('htmlOptions' => array('empty'=>'-'),'data' => Helper::generateCountedArray(0, 10))));
            echo $form->dropDownListGroup($model, 'tradestatus_id', array('widgetOptions' => array('htmlOptions' => array('empty'=>'-'),'data' => CHtml::listData(Tradestatus::model()->findAll(), 'id', 'label'))));
            ?>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <?php echo CHtml::activeLabel($model, 'taper'); ?>
                    <?= $form->textField($model, 'taper', array('maxlength' => 255, 'class' => 'form-control')); ?>
                </div>
                <div class="form-group col-md-6">
                    <?php echo CHtml::activeLabel($model, 'transferer'); ?>
                    <?= $form->textField($model, 'transferer', array('maxlength' => 255, 'class' => 'form-control')); ?>
                </div>
            </div>
            <?php

            echo $form->textFieldGroup($model, 'userdefined1', array('widgetOptions' => array('htmlOptions' => array('maxlength' => 255))));
            echo $form->textFieldGroup($model, 'userdefined2', array('widgetOptions' => array('htmlOptions' => array('maxlength' => 255))));
            ?>
            <div class="form-group row">
                <div class="col-sm-3"><?php echo CHtml::activeLabel($model, 'visible'); ?></div>
                <div class="col-sm-3"><?php echo $form->checkBox($model, 'visible'); ?></div>
            </div>
        </div>
        <div id="middle" class="column">
            <!--  include video OR audio infos -->
            <?php include($vaId == VA::VIDEO ? '_video.php' : '_audio.php'); ?>

        </div>
        <div id="right" class="column">
            <?php
            echo $form->textAreaGroup($model, 'setlist', array('rows' => 5, 'cols' => 50));
            echo $form->textAreaGroup($model, 'notes', array('rows' => 5, 'cols' => 50));
            echo $form->textAreaGroup($model, 'sourcenotes', array('rows' => 5, 'cols' => 50));
            echo $form->textAreaGroup($model, 'hiddennotes', array('rows' => 3, 'cols' => 50));
            ?>

        </div>
    </div>

    <?php $this->widget('booster.widgets.TbButton', array('buttonType' => 'submit', 'context' => 'primary', 'label' => 'save')); ?>

    <?php $this->endWidget(); ?>

</div><!-- form -->