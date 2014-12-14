<?php
$this->beginWidget('bootstrap.widgets.TbModal', 
        array('id' => 'editConcert'));
?>

<div class="modal-header">
    <a class="close" data-dismiss="modal">&times;</a>
    <h4>Edit Concert</h4>
</div>
<div class="modal-body" style="max-height:600px !important;">
    <div class="form">
        <?php
        $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
            'id' => 'inlineForm',
            'type' => 'horizontal',
            'htmlOptions' => array('class' => 'well'),
            'action' => Yii::app()->createUrl('adminEditRecord/updateConcertInfo', array(ParamHelper::PARAM_RECORD_ID => $recordId)),
                ));
        echo CHtml::errorSummary($concertFormModel);
        echo CHtml::activeHiddenField($concertFormModel, 'artist');

        $this->renderPartial('/adminBase/concertForm', array('model' => $concertFormModel, 'form' => $form));
        ?>

        <div class="form-actions">
            <?php $this->widget('bootstrap.widgets.TbButton', array('buttonType' => 'submit', 'type' => 'primary', 'label' => 'OK')); ?>
        </div>

        <?php $this->endWidget(); ?>
    </div>
</div>

<?php 
$this->endWidget(); 

?>


