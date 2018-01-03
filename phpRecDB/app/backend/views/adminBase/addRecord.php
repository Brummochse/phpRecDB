<?php

$this->beginWidget('booster.widgets.TbPanel', array(
    'title' => 'Add New Record',
    'htmlOptions' => array('class' => 'bootstrap-box-small'),
));

$this->widget('booster.widgets.TbTabs', array(
    'type' => 'tabs',
    'htmlOptions' => array('class' => 'well-tabnav'),
    'tabs' => $tabItems
    )
);

$this->endWidget(); 

?>
