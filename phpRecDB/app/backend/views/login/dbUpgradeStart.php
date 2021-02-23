<div style="width:600px;text-align-last: center;margin: 50px auto auto;">

    <?php
    $this->beginWidget('booster.widgets.TbPanel', array(
        'title' => 'administration area',
    ));
    ?>
    <div style="margin: 20px;">
        <?php echo CHtml::image(Yii::app()->params['wwwUrl'] . '/images/logo.png', 'phpRecDB',array ('style'=>'width:100%')); ?>
    </div>
    <?php
    $form = $this->beginWidget('booster.widgets.TbActiveForm', array(
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
        <?php echo CHtml::link('<button type="button">upgrade Database</button>', array('login/upgradeDB')); ?>
    </div>

    <?php
    $this->endWidget();
    $this->endWidget();
    ?>
</div>