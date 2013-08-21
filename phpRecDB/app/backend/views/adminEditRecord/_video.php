<div class="row">
    <?php echo $form->labelEx($vaModel, 'authorer'); ?>
    <?php echo $form->textField($vaModel, 'authorer', array('size' => 50, 'maxlength' => 50)); ?>
    <?php echo $form->error($vaModel, 'authorer'); ?>
</div>

<div class="row">
    <?php echo $form->labelEx($vaModel, 'videoformat_id'); ?>
    <?= $form->dropDownList($vaModel, 'videoformat_id', CHtml::listData(Videoformat::model()->findAll(), 'id', 'label'), Helper::$dropBoxDefaultNullStr); ?>
    <?php echo $form->error($vaModel, 'videoformat_id'); ?>
</div>

<div class="row">
    <?php echo $form->labelEx($vaModel, 'aspectratio_id'); ?>
    <?= $form->dropDownList($vaModel, 'aspectratio_id', CHtml::listData(Aspectratio::model()->findAll(), 'id', 'label'), Helper::$dropBoxDefaultNullStr); ?>
    <?php echo $form->error($vaModel, 'aspectratio_id'); ?>
</div>

<div class="row">
    <?php echo $form->labelEx($vaModel, 'bitrate'); ?>
    <?php echo $form->textField($vaModel, 'bitrate', array('size' => 10, 'maxlength' => 10)); ?>
    <?php echo $form->error($vaModel, 'bitrate'); ?>
</div>