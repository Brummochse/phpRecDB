<?php
$this->widget('CTabView',array(
    'activeTab'=>'tab1',
    'tabs'=>array(
        'tab1'=>array(
            'title'=>'New Install',
            'view'=>'pages/_installNew'
        ),
        'tab2'=>array(
            'title'=>'Upgrade',
            'view'=>'pages/_installUpgrade'
        )
    ),
));
?>
