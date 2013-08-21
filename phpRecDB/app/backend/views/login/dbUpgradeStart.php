<?php
//infrastructure for ajax loading dialogs with loading animation
$this->widget('LoadingWidget');
$ajaxUpdateOption = array('update' => '#dialog_div', 'beforeSend' => 'function(){Loading.show();}', 'complete' => 'function(){ Loading.hide();}');
?>
<div id="dialog_div" style="display: none"></div>



<div style="width:500px;text-align-last: center;margin: 50px auto auto;">

    <?php
    $this->beginWidget('bootstrap.widgets.TbBox', array(
        'title' => 'administration area',
    ));
    ?>
    <div style="margin: 20px;">
        <?php echo CHtml::image(Yii::app()->params['wwwUrl'] . '/images/logo.png', 'phpRecDB'); ?>
    </div>
    <?php
    $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
        'id' => 'horizontalForm',
        'type' => 'horizontal',
        'htmlOptions' => array('class' => 'well'),
    ));
    ?>
    <h1>Database Upgrade</h1>

    <p>Your Database schema is not up to date and needs an upgrade. </p>
    <p>Before upgrading it is strongly recommended to <span style='color:red;font-weight:bolder;'>backup your mysql database</span> (for restoring your data if database upgrade fails). </p>
    <p >After clicking the upgrade-Button, <span style='color:red;font-weight:bolder;'>DO NOT CLOSE THIS PAGE</span> and wait for the response. This can take some seconds.</p> 

    <div style="text-align: center;">
     <?php echo CHtml::ajaxButton('upgrade Database', array('login/upgradeDB'), $ajaxUpdateOption); ?>
    </div>

    <?php
    $this->endWidget();
    $this->endWidget();
    ?>
</div>