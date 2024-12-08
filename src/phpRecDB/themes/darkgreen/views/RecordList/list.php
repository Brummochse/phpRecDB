<?php

$this->widget('CPrdGridViewCore', array(
    'dataProvider' => $listDataProvider,
    'columns' => $listColumns,
    'cssFile' => Yii::app()->getTheme()->getBaseUrl() . '/css/recordList.css',
    'pager' => array('cssFile' => Yii::app()->getTheme()->getBaseUrl() . '/css/recordList.css'),
));
?>