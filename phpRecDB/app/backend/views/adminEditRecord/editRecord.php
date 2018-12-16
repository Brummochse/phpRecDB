<?php
$this->beginWidget('booster.widgets.TbPanel', array(
    'title' => CHtml::link($artistName, $artistListUrl) . ' ' . $concertInfo,
    'htmlOptions' => array('class' => 'bootstrap-box-big'),
    'headerButtons' => array(
        array(
            'class' => 'booster.widgets.TbButtonGroup',
            'buttons' => array(
                 array('items' => array(
                        array('label' => 'add Video Record', 'url' => Yii::app()->createUrl('adminEditRecord/addVideoRecord', array(ParamHelper::PARAM_CONCERT_ID => $concertId))),
                        array('label' => 'add Audio Record', 'url' => Yii::app()->createUrl('adminEditRecord/addAudioRecord', array(ParamHelper::PARAM_CONCERT_ID => $concertId))),
                        ($allowDeleteRecord) ? '---' : array(),
                        ($allowDeleteRecord) ? array('label' => 'delete selected Record', 'url' => Yii::app()->createUrl('adminEditRecord/deleteRecord', array(ParamHelper::PARAM_RECORD_ID => $recordId))) : array(),
                    ),'htmlOptions' => array('class'=>'btn-dark')),

            )
        ),
        array(
            'class' => 'booster.widgets.TbButtonGroup',
            'buttons' => array(
                array(
                    'label' => 'Edit',
                    'htmlOptions' => array(
                        'data-toggle' => 'modal',
                        'data-target' => '#editConcert',
                       'class'=>'btn-dark'
                    )),
            ),
        ),
      
    )
));
?>
<div class="recordsInlay">
    <?php
    $this->widget('booster.widgets.TbMenu', array(
        'type' => 'list',
        'items' => $recordChoiceMenuItems,
    ));
    ?>
</div>
<?php
$this->widget('booster.widgets.TbTabs', array(
    'type' => 'tabs',
    'htmlOptions' => array('class' => 'well-tabnav'),
    'tabs' => $tabs)
);
$this->endWidget();

$this->renderPartial('_editConcert', array('recordId' => $recordId, 'concertFormModel' => $concertFormModel));
?>
