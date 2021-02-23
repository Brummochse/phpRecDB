<div style="width:1150px;text-align-last: center;margin: 50px auto auto;">
    <?php

    $this->beginWidget('booster.widgets.TbPanel', array(
        'title' => 'administration area',
    ));
    $this->widget('zii.widgets.jui.CJuiAccordion', array(
        'panels' => $migrationInfoPanel,
        'options' => array(
            'collapsible' => true,
            'active' => false,
        ),
        'htmlOptions' => array(
            'style' => 'width:1000px;text-align-last: center; margin: 20px auto 50px auto;'
        ),
    ));
    ?>
    <div style="text-align: center;">
       <?php echo CHtml::link('<button type="button">OK</button>', array('login/login')); ?>
    </div>
    <?php
    $this->endWidget();
    ?>

</div>


