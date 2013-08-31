<?php
$appPath = dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..';
require_once($appPath . DIRECTORY_SEPARATOR . 'common' . DIRECTORY_SEPARATOR . 'components' . DIRECTORY_SEPARATOR . 'PathResolver.php');
$phpRecDbPath = PathResolver::resolvePath($appPath . DIRECTORY_SEPARATOR . '..',DIRECTORY_SEPARATOR);
$phpRecDbUrl = PathResolver::getRelativePathTo($phpRecDbPath);

Yii::setPathOfAlias('common', $appPath . DIRECTORY_SEPARATOR . 'common');

return array(
    'preload' => array(
        'settingsManager',
    ),
    'language'=>'en_us',
    'sourceLanguage'=>'en_us',

    'charset'=>'utf-8',
    'components' => array(
        'settingsManager' => array('class' => 'SettingsManager'),
        'assetManager' => array(
            'basePath' => $phpRecDbPath . '/assets/',
            'baseUrl' => $phpRecDbUrl .(empty($phpRecDbUrl)?'':'/'). 'assets',
        ),
        'themeManager' => array(
            'basePath' => $phpRecDbPath . '/themes',
            'baseUrl' =>  $phpRecDbUrl .(empty($phpRecDbUrl)?'':'/') . 'themes',
        ),
//        'request' => array(
//            'baseUrl' =>  $phpRecDbUrl,
//        ),
    ),
    'import' => array(
        'common.components.*',
        'common.models.*',
        'common.models.orm.*',
        'common.extensions.mbmenu.MbMenu',
        'common.extensions.loading.LoadingWidget',
        'common.components.widgets.RecordList.*',
        'common.components.widgets.RecordList.PrdGridView.*',
        'common.components.widgets.RecordList.ListDataConfigs.*',

        
    ),
    'params' => require(dirname(__FILE__) . '/params.php'),
);