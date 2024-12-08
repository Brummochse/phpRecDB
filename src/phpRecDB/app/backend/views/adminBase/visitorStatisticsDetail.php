<?php

$this->beginWidget('booster.widgets.TbPanel', array(
    'title' => 'Last visited phpRecDB-pages by Visitor with ip: [' . $ip . ']',
    'htmlOptions' => array('class' => 'bootstrap-box-big'),
));

?>

<p>
    <?php
    $this->widget('booster.widgets.TbLabel', array('label' => 'Visitor Ip Address:',));
    echo ' '.$ip;
    ?>
</p>
<p>
    <?php
    $this->widget('booster.widgets.TbLabel', array('label' => 'Try to Lookup IP:',));
    echo ' '.CHtml::link('ip lookup', $ipLookUpUrl);
    ?>
</p>  

<?php

$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider' => $visitedPages,
    'columns' => array(
        array(
            'name' => 'date',
            'header' => 'visit time'
        ),
        array(
            'name' => 'pageLabel',
            'type' => 'raw',
            'header' => 'visited page'
        ),
    ),
));
?>

<?php $this->endWidget(); ?>

