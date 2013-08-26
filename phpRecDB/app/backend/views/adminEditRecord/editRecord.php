<?php
$this->beginWidget('bootstrap.widgets.TbBox', array(
    'title' => CHtml::link($artistName, $artistListUrl) . ' ' . $concertInfo,
    'htmlOptions' => array('class' => 'bootstrap-box-big'),
    'headerButtons' => array(
        array(
            'class' => 'bootstrap.widgets.TbButtonGroup',
            'type' => 'inverse',
            'buttons' => array(
                array('items' => array(
                        array('label' => 'add Video Record', 'url' => Yii::app()->createUrl('adminEditRecord/addVideoRecord', array(ParamHelper::PARAM_CONCERT_ID => $concertId))),
                        array('label' => 'add Audio Record', 'url' => Yii::app()->createUrl('adminEditRecord/addAudioRecord', array(ParamHelper::PARAM_CONCERT_ID => $concertId))),
                        ($allowDeleteRecord) ? '---' : array(),
                        ($allowDeleteRecord) ? array('label' => 'delete selected Record', 'url' => Yii::app()->createUrl('adminEditRecord/deleteRecord', array(ParamHelper::PARAM_RECORD_ID => $recordId))) : array(),
                    )),
            )
        ),
        array(
            'class' => 'bootstrap.widgets.TbButtonGroup',
            'type' => 'inverse',
            'buttons' => array(
                array(
                    'label' => 'Edit',
                    'type' => 'inverse',
                    'htmlOptions' => array(
                        'data-toggle' => 'modal',
                        'data-target' => '#editConcert',
                    )),
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

$this->renderPartial('_editConcert', array('recordId' => $recordId, 'concertFormModel' => $concertFormModel));
?>
