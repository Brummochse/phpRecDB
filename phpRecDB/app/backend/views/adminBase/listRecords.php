<?php

$this->beginWidget('bootstrap.widgets.TbBox', array(
    'title' => CHtml::encode($title),
    'htmlOptions' => array('class' => 'bootstrap-box-big'),
));

$form = $this->beginWidget('CActiveForm', array(
    'enableAjaxValidation' => true,
        ));

$this->widget('RecordList', array('data' => $data,'id'=>'recordlist-grid'));
?>

<script>
    function reloadGrid(data) {
        $.fn.yiiGridView.update('recordlist-grid');
    }
</script>

<?php

$this->beginWidget('application.extensions.rightsidebar.RightSidebar', array('title' => 'Selected Records', 'collapsed' => true));
echo CHtml::ajaxSubmitButton('Assign to sublist', Yii::app()->createUrl('adminBase/assignRecordsToSublist'), array('success' => 'reloadGrid'));
echo CHtml::listbox(ParamHelper::PARAM_SUBLIST_ID, -1, CHtml::listData(Sublist::model()->findAll(), 'id', 'label'));
echo CHtml::ajaxSubmitButton('Delete', Yii::app()->createUrl('adminBase/deleteRecords'), array('success' => 'reloadGrid'));
$this->endWidget();
?>
<?php $this->endWidget(); ?>

<?php $this->endWidget(); ?>