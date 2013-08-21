<?php
$this->beginWidget('bootstrap.widgets.TbBox', array(
    'title' => CHtml::link($artistName, $artistListUrl) . ' ' . $concertInfo,
    'htmlOptions' => array('class' => 'bootstrap-box-big'),
    'headerButtons' => array(
        array(
            'class' => 'bootstrap.widgets.TbButtonGroup',
            'type' => 'Secondary', // '', 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
            'buttons' => array(
                array('items' => array(
                        array('label' => 'add Video Record', 'url' => Yii::app()->createUrl('adminEditRecord/addVideoRecord', array(ParamHelper::PARAM_CONCERT_ID => $concertId))),
                        array('label' => 'add Audio Record', 'url' => Yii::app()->createUrl('adminEditRecord/addAudioRecord', array(ParamHelper::PARAM_CONCERT_ID => $concertId))),
                        ($allowDeleteRecord) ? '---':array(),
                        ($allowDeleteRecord) ? array('label' => 'delete selected Record', 'url' => Yii::app()->createUrl('adminEditRecord/deleteRecord', array(ParamHelper::PARAM_RECORD_ID => $recordId))) : array(),
                )),
            )
        ),
        array(
            'class' => 'bootstrap.widgets.TbButtonGroup',
            'buttons' => array(
                array('label' => 'Edit', 'htmlOptions' => array('onclick' => '$("#editconcertmodal").dialog("open"); return false;'))
            ),
        ),
    )
));
?>
<div class="recordsInlay">
    <?php
    $this->widget('bootstrap.widgets.TbMenu', array(
        'type' => 'list',
        'items' => $recordChoiceMenuItems,
    ));
    ?>
</div>
<?php
$this->widget('bootstrap.widgets.TbTabs', array(
    'type' => 'pills',
    'htmlOptions' => array('class' => 'well'),
    'tabs' => $tabs)
);




$this->endWidget();

$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'editconcertmodal',
    'options' => array(
        'title' => 'Edit Concert',
        'width' => 600,
        'autoOpen' => false,
        'resizable' => false,
        'modal' => true,
        'overlay' => array(
            'backgroundColor' => '#000',
            'opacity' => '0.5'
        ),
    ),
));
?>
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
<?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>
