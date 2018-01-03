<?php
$this->beginWidget('booster.widgets.TbPanel', array(
    'title' => 'Screenshot Statistics',
    'htmlOptions' => array('class' => 'bootstrap-box-small'),
));
?>
<p>
    <?php
    $this->widget('booster.widgets.TbLabel', array('label' => 'Files in Screenshots Folder:',));
    echo " " . $filesCount. " files";
    ?>
</p>
<p>
    <?php
    $this->widget('booster.widgets.TbLabel', array('label' => 'Size of Screenshots Folder:',));
    echo " " . $filesSize . " MB";
    ?>
</p>   
<?php $this->endWidget(); ?>