<p>phpRecDB is a free php script to create a live record collection site (so called bootleg trading page).</p>
<p>This software is licensed under the GPLv3.(free for non-commercial usage)</p>
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

