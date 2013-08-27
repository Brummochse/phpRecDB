<?php
$this->widget('CTabView',array(
    'activeTab'=>'tab1',
    'tabs'=>array(
        'tab1'=>array(
            'title'=>'last version',
            'view'=>'pages/_downloadsNew'
        ),
        'tab2'=>array(
            'title'=>'old versions',
            'view'=>'pages/_downloadsOld'
        )
    ),
));
?>

