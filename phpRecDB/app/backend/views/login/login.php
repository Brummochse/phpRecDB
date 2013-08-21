<div style="width:500px;text-align-last: center;margin: 50px auto auto;">

    <?php
    $this->beginWidget('bootstrap.widgets.TbBox', array(
        'title' => 'administration area',
    ));
    ?>
    <div style="margin: 20px;">
        <?php echo CHtml::image(Yii::app()->params['wwwUrl'] . '/images/logo.png', 'phpRecDB'); ?>
    </div>
    <?php
    $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
        'id' => 'horizontalForm',
        'type' => 'horizontal',
        'htmlOptions' => array('class' => 'well'),
            ));
    ?>

    <?php echo $form->textFieldRow($model, 'username', array('class' => 'input-small','autocomplete'=>'off')); ?>
    <?php echo $form->passwordFieldRow($model, 'password', array('class' => 'input-small')); ?>
    <?= $welcomeMessage ?>
    <div style="text-align: center;">
        <?php $this->widget('bootstrap.widgets.TbButton', array('buttonType' => 'submit', 'label' => 'Log in')); ?>
    </div>
    <?php $this->endWidget(); ?>
    <?php
    $this->endWidget();
    ?>
</div>

