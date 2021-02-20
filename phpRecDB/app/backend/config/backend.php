<?php

$appPath = dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..';
require_once($appPath . DIRECTORY_SEPARATOR . 'common' . DIRECTORY_SEPARATOR . 'components' . DIRECTORY_SEPARATOR . 'PathResolver.php');
$phpRecDbPath = PathResolver::resolvePath($appPath . DIRECTORY_SEPARATOR . '..', DIRECTORY_SEPARATOR);
$phpRecDbUrl = PathResolver::getRelativePathTo($phpRecDbPath);

Yii::setPathOfAlias('common', $appPath . DIRECTORY_SEPARATOR . 'common');

return array(

    'defaultController' => 'login',
    'basePath' => $appPath . '/backend',
    'name' => 'phpRecDB Administration Panel',
    'onBeginRequest' => array('DbMigrator', 'checkDbState'), //check db version on start up
    'preload' => array('bootstrap'),
    'components' => array(
        'user' => array(
            'allowAutoLogin' => false,
            'loginUrl' => array('login/login'),
            'class' => 'WebUser',
            'authExpires' => 20 /* minutes */ * 60 /* seconds */, //means auto log out after 20 min
        ),
        'recordManager' => array('class' => 'RecordManager'),
        'signatureManager' => array('class' => 'SignatureManager'),
        'screenshotManager' => array('class' => 'ScreenshotManager'),
        'dbCleaner' => array('class' => 'DbCleaner'),
        'dbMigrator' => array('class' => 'DbMigrator'),
        'helpCreator' => array('class' => 'HelpCreator', 'helpFilesPath'=>'application.views.help'),
        'bootstrap' => array('class' => 'ext.yiibooster-4-0-1.components.Booster'),
        'urlManager'=>array(
            'urlFormat'=>'path',
            'rules'=>array(
                // REST patterns
//                array('api/list', 'pattern'=>'api/<model:\w+>', 'verb'=>'GET'),
//                array('api/view', 'pattern'=>'api/<model:\w+>/<id:\d+>', 'verb'=>'GET'),
//                array('api/update', 'pattern'=>'api/<model:\w+>/<id:\d+>', 'verb'=>'PUT'),
//                array('api/delete', 'pattern'=>'api/<model:\w+>/<id:\d+>', 'verb'=>'DELETE'),
//                array('api/create', 'pattern'=>'api/<model:\w+>', 'verb'=>'POST'),
                // Other controllers
//                '<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
            ),
        ),
    ),
    'import' => array(
        'application.components.*',
        'application.components.user.*',
        'application.components.api.*',
        'application.models.*',
        'application.models.orm.*',
    ),
    'params' => require(dirname(__FILE__) . '/params.php'),
);
