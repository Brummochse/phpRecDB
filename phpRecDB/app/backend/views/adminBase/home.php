<?php
$this->beginWidget('booster.widgets.TbPanel', array(
    'title' => 'phpRecDB',
    'headerIcon' => 'home',
    'htmlOptions' => array('class' => 'bootstrap-box-small'),
));

    $this->widget('booster.widgets.TbDetailView', array(
        'data' => $phpRecDbInfo,
    ));
?>

for updates check <?= CHtml::link("www.phpRecDB.com", "http://www.phpRecDB.com "); ?>

<?php $this->endWidget(); ?>

<br>
<?php
$this->beginWidget('booster.widgets.TbPanel', array(
    'title' => 'Server Information',
    'headerIcon' => 'info-sign',
    'htmlOptions' => array('class' => 'bootstrap-box-small'),
));

    $this->widget('booster.widgets.TbDetailView', array(
        'data' => $serverInfos,
        'attributes' => $serverInfoAttributes,
    ));

$this->endWidget();
?>