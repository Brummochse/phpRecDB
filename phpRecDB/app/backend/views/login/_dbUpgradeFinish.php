<?php
Yii::app()->clientScript->registerCss('hideDialogCloseBtnCss','.no-close .ui-dialog-titlebar-close {display: none;}');

$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'cssFile' => 'jquery-ui.css',
    'theme' => "css",
    'themeUrl' => Yii::app()->params['wwwUrl'],
    'options' => array(
        'title' => 'Database Upgrade Log',
        'autoOpen' => true,
        'modal' => true,
        'width' => 'auto',
        'close' => "js:function(){ $(this).dialog('destroy').remove(); }",
        'dialogClass' => 'no-close',
    ))
);

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

$this->widget('bootstrap.widgets.TbButton', array(
    'label' => 'OK',
    'url' => array('login/login'),
));

$this->endWidget('zii.widgets.jui.CJuiDialog');
?>


