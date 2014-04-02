
    
<?php $this->beginContent('/layouts/main'); ?>

<?php
Yii::app()->clientScript->registerCssFile(Yii::app()->params['wwwUrl'] . '/css/form.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->params['wwwUrl'] . '/css/admin.css');

$this->widget('bootstrap.widgets.TbNavbar', array(
    'brandUrl' => Yii::app()->HomeUrl,
    'type' => 'inverse',
    'items' => array(
        array(
            'class' => 'bootstrap.widgets.TbMenu',
            'items' => $this->getMenuItems()
        ),
        array(
            'class' => 'bootstrap.widgets.TbMenu',
            'htmlOptions' => array('class' => 'pull-right',
                'data-toggle' => 'modal',
                'data-target' => '#notificationsmodal',
            ),
            'items' => $this->getNotificationMenuItems()
        ),
    )
));
?>

<div id="content">
    <?= $content ?>
</div>



<?php $this->endContent(); ?>


<?php
//notifications modal///////////////////begin
$this->beginWidget('bootstrap.widgets.TbModal', array(
    'id' => 'notificationsmodal',
    'autoOpen' => $this->hasErrorFlashs()
));
?>
<div class="modal-header">
    <a class="close" data-dismiss="modal">&times;</a>
    <h4>Notifications</h4>
</div>
<div class="modal-body" style="max-height:600px !important;">
 <?= $this->getNotificationsHtml();   ?>   
</div>
</div>
<?php 
$this->endWidget(); 
//notifications modal///////////////////begin
?>