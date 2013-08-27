<?php
$this->beginWidget('bootstrap.widgets.TbBox', array(
    'title' => 'Screenshot Statistics',
    'htmlOptions' => array('class' => 'bootstrap-box-small'),
));
?>
<p>
    <?php
    $this->widget('bootstrap.widgets.TbLabel', array('label' => 'Files in Screenshots Folder:',));
    echo " " . $filesCount. " files";
    ?>
</p>
<p>
    <?php
    $this->widget('bootstrap.widgets.TbLabel', array('label' => 'Size of Screenshots Folder:',));
    echo " " . $filesSize . " MB";
    ?>
</p>   
<?php $this->endWidget(); ?>