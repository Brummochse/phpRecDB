<?php 
    echo CHtml::beginForm();
    echo CHtml::submitButton('Refresh Statistics');
    echo CHtml::radioButtonList('recType', $this->recTypeSelection, $this->recTypesList, array(
        'labelOptions' => array('style' => 'display:inline'),
        'separator' => '',
    ));
 ?>
<span style="float: right">
<?php
    echo CHtml::checkBox('includeMisc', $this->includeMisc)
?>
<label for="includeMisc">include misc recordings</label>
</span>
<?php
    echo CHtml::endForm(); 
?>