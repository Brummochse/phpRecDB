<?php
$this->beginWidget('bootstrap.widgets.TbBox', array(
    'title' => 'phpRecDB',
    'headerIcon' => 'icon-home',
    'htmlOptions' => array('class' => 'bootstrap-box-small'),
));

    $this->widget('bootstrap.widgets.TbDetailView', array(
        'data' => $phpRecDbInfo,
    ));
?>

for updates check <?= CHtml::link("www.phpRecDB.de.vu", "http://www.phpRecDB.de.vu"); ?>

<?php $this->endWidget(); ?>

<br>
<?php
$this->beginWidget('bootstrap.widgets.TbBox', array(
    'title' => 'Server Information',
    'headerIcon' => 'icon-info-sign',
    'htmlOptions' => array('class' => 'bootstrap-box-small'),
));

    $this->widget('bootstrap.widgets.TbDetailView', array(
        'data' => $serverInfos,
        'attributes' => $serverInfoAttributes,
    ));

$this->endWidget();
?>