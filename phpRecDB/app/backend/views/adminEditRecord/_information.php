<div class="form">
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
            echo $form->textFieldGroup($model, 'sumlength', array('widgetOptions' => array('htmlOptions' => array('maxlength' => 10))));
            echo $form->dropDownListGroup($model, 'media_id', array('widgetOptions' => array('htmlOptions' => array('empty'=>'-'),'data' => CHtml::listData(Medium::model()->findAllByAttributes(array('bootlegtypes_id' => $vaId)), 'id', 'label'))));
            echo $form->textFieldGroup($model, 'summedia', array('widgetOptions' => array('htmlOptions' => array('maxlength' => 10))));
            echo $form->dropDownListGroup($model, 'quality', array('widgetOptions' => array('htmlOptions' => array('empty'=>'-'),'data' => Helper::generateCountedArray(0, 10))));
            echo $form->dropDownListGroup($model, 'tradestatus_id', array('widgetOptions' => array('htmlOptions' => array('empty'=>'-'),'data' => CHtml::listData(Tradestatus::model()->findAll(), 'id', 'label'))));
            echo $form->textFieldGroup($model, 'taper', array('widgetOptions' => array('htmlOptions' => array('maxlength' => 255))));
            echo $form->textFieldGroup($model, 'transferer', array('widgetOptions' => array('htmlOptions' => array('maxlength' => 255))));
            ?>
            <div class="form-group">
                <?php echo CHtml::activeLabel($model, 'visible'); ?>
                <?php echo $form->checkBox($model, 'visible'); ?>
            </div>
            <?php
            echo $form->textFieldGroup($model, 'userdefined1', array('widgetOptions' => array('htmlOptions' => array('maxlength' => 255))));
            echo $form->textFieldGroup($model, 'userdefined2', array('widgetOptions' => array('htmlOptions' => array('maxlength' => 255))));
            ?>
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