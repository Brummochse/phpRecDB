<?php
$appPath = dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..';
Yii::setPathOfAlias('common', $appPath . DIRECTORY_SEPARATOR . 'common');
require_once($appPath . DIRECTORY_SEPARATOR . 'common' . DIRECTORY_SEPARATOR . 'components' . DIRECTORY_SEPARATOR . 'PathResolver.php');
$phpRecDbPath = PathResolver::resolvePath($appPath . DIRECTORY_SEPARATOR . '..',DIRECTORY_SEPARATOR);
$phpRecDbUrl = PathResolver::getRelativePathTo($phpRecDbPath);

return array(
    'defaultController' => 'site',
    'basePath' => $appPath . '/frontend',
    'components' => array(
         'assetManager' => array(
            'basePath' => $phpRecDbPath . '/assets/',
            'baseUrl' => $phpRecDbUrl .(empty($phpRecDbUrl)?'':'/'). 'assets',
        ),
    ),
    'import' => array(
        'application.components.*',
        'application.components.widgets.statistician.Statistician',
        'application.components.widgets.collectionSupplier.CollectionSupplier',
        'application.components.widgets.recordViewer.RecordViewer',
    ),
    'params' => require(dirname(__FILE__) . '/params.php'),
);