<?php

$this->beginWidget('bootstrap.widgets.TbBox', array(
    'title' => 'Add New Record',
    'htmlOptions' => array('class' => 'bootstrap-box-small'),
));
?>


<?php
$this->widget('bootstrap.widgets.TbTabs', array(
    'type' => 'tabs',
    'htmlOptions' => array('class' => 'well-tabnav'),
    'tabs' => $tabItems
    )
);
?>

<?php $this->endWidget(); ?>
