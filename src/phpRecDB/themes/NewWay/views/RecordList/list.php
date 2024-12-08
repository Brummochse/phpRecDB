<?php

$this->widget('CPrdGridViewCore', array(
    'dataProvider' => $listDataProvider,
    'columns' => $listColumns,
    'cssFile' => Yii::app()->getTheme()->getBaseUrl() . '/css/recordList1.css',
    'pager' => array('cssFile' => Yii::app()->getTheme()->getBaseUrl() . '/css/recordList1.css'),
));
?>