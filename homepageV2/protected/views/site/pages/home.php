<p>phpRecDB is a free php script for creating a bootleg trading site.</p>
<p>I programmed it for my own trading page (<a href="http://www.ratm-bootlegs.de.vu">www.ratm-bootlegs.de.vu</a>) because there was no free software available before.</p>

<?php
$this->beginWidget('yiiwheels.widgets.box.WhBox', array(
    'title' => 'News',
    'headerIcon' => 'icon-th-list',
    'htmlOptions' => array('style' => 'width:600px;margin:auto;'),
    'htmlContentOptions' => array('style' => 'background: #d2dcfF;padding:0;')
));
include dirname(__FILE__) . '/_news.php';
$this->endWidget();
?>

