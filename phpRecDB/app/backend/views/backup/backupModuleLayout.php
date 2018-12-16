<?php $this->beginContent('//layouts/admin'); ?>
<?php



$this->beginWidget('booster.widgets.TbPanel', array(
    'title' => 'Manage database backup files',
    'htmlOptions' => array('class' => 'bootstrap-box-big'),
    'headerButtons' => array(
        Yii::app()->helpCreator->renderModalAndGetHelpBtn($this,'backup'),
        array(
            'class' => 'booster.widgets.TbButtonGroup',
            'context' => 'inverse',
            'buttons' => array(
                array('label' => 'Upload Backup', 'url' => array('upload'),'buttonType' =>'link','htmlOptions' => array('class'=>'btn-dark'))
            ),
        ),
        array(
            'class' => 'booster.widgets.TbButtonGroup',
            'context' => 'inverse',
            'buttons' => array(
                array('label' => 'Manage Backups', 'url' => array('index'),'buttonType' =>'link','htmlOptions' => array('class'=>'btn-dark')),
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
