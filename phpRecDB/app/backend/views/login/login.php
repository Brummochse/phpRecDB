<div style="width:500px;text-align-last: center;margin: 50px auto auto;">

    <?php
    $this->beginWidget('booster.widgets.TbPanel', array(
        'title' => 'administration area',
    ));
    ?>
    <div style="margin: 20px;">
        <?php echo CHtml::image(Yii::app()->params['wwwUrl'] . '/images/logo.png', 'phpRecDB',array ('style'=>'width:100%')); ?>
    </div>
    <?php
    $form = $this->beginWidget('booster.widgets.TbActiveForm', array(
        'id' => 'horizontalForm',
        'type' => 'horizontal',
        'htmlOptions' => array('class' => 'well'),
            ));
    ?>
    <?php echo $form->textFieldGroup($model, 'username', array( 'widgetOptions'=>array ('htmlOptions'=>array('autocomplete'=>'off')))); ?>
    <?php echo $form->passwordFieldGroup($model, 'password', array()); ?>
    <?= $welcomeMessage ?>
    <div style="text-align: center;">
        <?php $this->widget('booster.widgets.TbButton', array('buttonType' => 'submit','context'=>'primary', 'label' => 'Log in')); ?>
    </div>
    <?php $this->endWidget(); ?>
    <?php
    $this->endWidget();
    ?>
</div>

