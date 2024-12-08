

<?php
echo $form->textFieldGroup($vaModel, 'authorer', array('widgetOptions' => array('htmlOptions' => array('maxlength' => 50))));


?>
<div class="form-row">
    <div class="form-group col-md-6">
        <?php echo CHtml::activeLabel($vaModel, 'videoformat_id'); ?>
        <?= $form->dropDownList($vaModel, 'videoformat_id',CHtml::listData(Videoformat::model()->findAll(), 'id', 'label'), array('class'=>'form-control','empty' => '-')); ?>
    </div>
    <div class="form-group col-md-6">
        <?php echo CHtml::activeLabel($vaModel, 'aspectratio_id'); ?>
        <?= $form->dropDownList($vaModel, 'aspectratio_id', CHtml::listData(Aspectratio::model()->findAll(), 'id', 'label'), array('class'=>'form-control','empty' => '-')); ?>
    </div>
</div>


<div class="form-row">
    <div class="form-group col-md-6">
        <?php echo CHtml::activeLabel($vaModel, 'width'); ?>
        <?= $form->textField($vaModel, 'width', array('maxlength' => 10,'class'=>'form-control')); ?>
    </div>
    <div class="form-group col-md-6">
        <?php echo CHtml::activeLabel($vaModel, 'height'); ?>
        <?= $form->textField($vaModel, 'height', array('maxlength' => 10,'class'=>'form-control')); ?>
    </div>
</div>


<div class="form-row">
    <div class="form-group col-md-6">
        <?php echo CHtml::activeLabel($vaModel, 'framerate'); ?>
        <?= $form->textField($vaModel, 'framerate', array('maxlength' => 10,'class'=>'form-control')); ?>
    </div>
    <div class="form-group col-md-6">
        <?php echo CHtml::activeLabel($vaModel, 'bitrate'); ?>
        <?= $form->textField($vaModel, 'bitrate', array('maxlength' => 10,'class'=>'form-control')); ?>
    </div>
</div>

<div class="form-group row">
    <div class="col-sm-3"><?php echo CHtml::activeLabel($vaModel, 'menu'); ?></div>
    <div class="col-sm-3"><?php echo $form->checkBox($vaModel, 'menu'); ?></div>
</div>
<div class="form-group row">
    <div class="col-sm-3"><?php echo CHtml::activeLabel($vaModel, 'chapters'); ?></div>
    <div class="col-sm-3"><?php echo $form->checkBox($vaModel, 'chapters'); ?></div>
</div>