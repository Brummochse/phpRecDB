<div class="form">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'enableAjaxValidation' => false,
            ));
    ?>

    <div class="row buttons">
        <?php echo CHtml::submitButton('Assign Record To Sublist'); ?>
        <?php echo CHtml::dropDownList(ParamHelper::PARAM_SUBLIST_ID, -1, CHtml::listData(Sublist::model()->findAll(), 'id', 'label')); ?>

    </div>

    <?php $this->endWidget(); ?>
</div><!-- form -->

<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider' => $dataProvider,
    'enableSorting' => false,
    'ajaxUpdate' => false,
    'columns' => array(
        array(
            'header' => 'Sublist',
            'value'=>'$data->sublist->label',
        ),
        array(
            'class' => 'CButtonColumn',
            'template' => '{delete}',
            'deleteButtonUrl' => 'Yii::app()->createUrl(\'adminEditRecord/deleteSublistAssignment\', array (ParamHelper::PARAM_SUBLIST_ID => $data->lists_id,ParamHelper::PARAM_RECORD_ID => $data->recordings_id))',
        )
    ),
));
?>