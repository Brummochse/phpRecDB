<?php $this->beginContent('/layouts/main'); ?>

<?php
Yii::app()->clientScript->registerCssFile(Yii::app()->params['wwwUrl'] . '/css/form.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->params['wwwUrl'] . '/css/admin.css');

$this->widget('bootstrap.widgets.TbNavbar', array(
    'brandUrl' => array('adminBase/Index'),
    'type' => 'inverse',
    'items' => array(
        array(
            'class' => 'bootstrap.widgets.TbMenu',
            'items' => $this->getMenuItems()
        ),
        array(
            'class' => 'bootstrap.widgets.TbMenu',
            'htmlOptions' => array('class' => 'pull-right','onclick' => '$("#notificationsmodal").dialog("open"); return false;'),
            'items' => $this->getNotificationMenuItems()
        ),
    )
));
?>

<div id="content">
    <?= $content ?>
</div>

<?php //dialog for notification messages 
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'notificationsmodal',
    'options' => array(
        'title' => 'Notifications',
        'width' => 600,
        'autoOpen' => false,
        'resizable' => false,
        'modal' => true,
    ),
)); 
?>
    <?= $this->getNotificationsHtml();   ?>
<?php $this->endWidget('zii.widgets.jui.CJuiDialog');?>

<?php $this->endContent(); ?>



