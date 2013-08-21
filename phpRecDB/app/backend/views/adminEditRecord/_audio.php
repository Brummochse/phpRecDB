<div class="row">
    <?php echo $form->labelEx($vaModel, 'bitrate'); ?>
    <?php echo $form->textField($vaModel, 'bitrate', array('size' => 10, 'maxlength' => 10)); ?>
    <?php echo $form->error($vaModel, 'bitrate'); ?>
</div>

<div class="row">
    <?php echo $form->labelEx($vaModel, 'frequence'); ?>
    <?php echo $form->textField($vaModel, 'frequence', array('size' => 10, 'maxlength' => 10)); ?>
    <?php echo $form->error($vaModel, 'frequence'); ?>
</div>