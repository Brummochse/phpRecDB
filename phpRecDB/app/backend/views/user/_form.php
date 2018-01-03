<div class="form">
    <?php
    $form = $this->beginWidget('booster.widgets.TbActiveForm', array(
        'id' => 'user-form',
    ));
        echo $form->textFieldGroup($model, 'username');
        echo $form->passwordFieldGroup($model, 'password');
        echo $form->dropDownListGroup($model, 'role' ,array ('widgetOptions'=>array ('data'=>$this->getRoles())));
        $this->widget('booster.widgets.TbButton',array('buttonType' => 'submit', 'label' => 'Create','context'=>'primary'));
    $this->endWidget(); ?>
</div>