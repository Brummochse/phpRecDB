<?php $this->beginContent('//layouts/admin'); ?>
<?php



$this->beginWidget('bootstrap.widgets.TbBox', array(
    'title' => 'Manage database backup files',
    'htmlOptions' => array('class' => 'bootstrap-box-big'),
    'headerButtons' => array(
        Yii::app()->helpCreator->renderModalAndGetHelpBtn($this,'backup'),
        array(
            'class' => 'bootstrap.widgets.TbButtonGroup',
            'type' => 'inverse',
            'buttons' => array(
                array('label' => 'Upload Backup', 'url' => array('upload'))
            ),
        ),
        array(
            'class' => 'bootstrap.widgets.TbButtonGroup',
            'type' => 'inverse',
            'buttons' => array(
                array('label' => 'Manage Backups', 'url' => array('index')),
            ),
        ),
    )
));
?>

<?php

echo $content;
?>

<?php $this->endWidget(); ?>
<?php $this->endContent(); ?>
