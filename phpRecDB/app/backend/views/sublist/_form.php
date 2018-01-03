<div class="form">

    <?php $form = $this->beginWidget('booster.widgets.TbActiveForm', array(
        'id' => 'sublist-form',
    ));
        echo $form->textFieldGroup($model, 'label');
        $this->widget('booster.widgets.TbButton', array('buttonType' => 'submit', 'label' => $model->isNewRecord ? 'Create' : 'Save', 'context' => 'primary'));
    $this->endWidget(); ?>

</div>