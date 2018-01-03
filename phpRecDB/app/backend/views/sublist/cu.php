<?php
$this->beginWidget('booster.widgets.TbPanel', array(
    'title' =>$model->isNewRecord ? 'Create Sublist' : 'Update Sublist "' . $model->label . '"',
    'htmlOptions' => array('class' => 'bootstrap-box-small'),
    'headerButtons' => array(
        array(
            'class' => 'booster.widgets.TbButtonGroup',
            'buttons' => array(
                array('label' => 'Manage Sublists', 'buttonType' => 'link', 'url' => array('admin'))
            ),
        ),
    )
));
?>
    <div class="form">
        <?php $form = $this->beginWidget('booster.widgets.TbActiveForm', array(
            'id' => 'sublist-form',
        ));
        echo $form->textFieldGroup($model, 'label');
        $this->widget('booster.widgets.TbButton', array('buttonType' => 'submit', 'label' => $model->isNewRecord ? 'Create' : 'Save', 'context' => 'primary'));
        $this->endWidget(); ?>
    </div>
<?php $this->endWidget(); ?>