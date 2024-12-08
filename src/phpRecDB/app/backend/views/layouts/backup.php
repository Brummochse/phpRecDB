<?php $this->beginContent('//layouts/admin'); ?>
<?php

$this->renderPartial('_backupHelp');
$this->beginWidget('booster.widgets.TbPanel', array(
    'title' => 'Manage database backup files',
    'htmlOptions' => array('class' => 'bootstrap-box-big'),
    'headerButtons' => array(
        array(
            'class' => 'booster.widgets.TbButtonGroup',
            'context' => 'inverse',
            'buttons' => array(
                array('label' => 'Help', 'htmlOptions' => array(
                        'data-toggle' => 'modal',
                        'data-target' => '#backupHelp',
                    ))
            ),
        ),
        array(
            'class' => 'booster.widgets.TbButtonGroup',
            'context' => 'inverse',
            'buttons' => array(
                array('label' => 'Upload Backup', 'url' => array('upload'))
            ),
        ),
        array(
            'class' => 'booster.widgets.TbButtonGroup',
            'context' => 'inverse',
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
