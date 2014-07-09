<?php
$appPath = dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..';
Yii::setPathOfAlias('common', $appPath . DIRECTORY_SEPARATOR . 'common');

return array(
    'defaultController' => 'site',
    'basePath' => $appPath . '/frontend',
    'components' => array(
        'listDataConfigurator' => array('class' => 'ListDataConfigurator'),
    ),
    'import' => array(
        'application.components.*',
        'application.components.widgets.statistician.Statistician',
        'application.components.widgets.collectionSupplier.CollectionSupplier',
        'application.components.widgets.recordViewer.RecordViewer',
    ),
    'params' => require(dirname(__FILE__) . '/params.php'),
);