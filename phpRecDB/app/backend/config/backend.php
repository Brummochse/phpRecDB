<?php

$appPath = dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..';
require_once($appPath . DIRECTORY_SEPARATOR . 'common' . DIRECTORY_SEPARATOR . 'components' . DIRECTORY_SEPARATOR . 'PathResolver.php');
$phpRecDbPath = PathResolver::resolvePath($appPath . DIRECTORY_SEPARATOR . '..',DIRECTORY_SEPARATOR);
$phpRecDbUrl = PathResolver::getRelativePathTo($phpRecDbPath);

Yii::setPathOfAlias('common', $appPath . DIRECTORY_SEPARATOR . 'common');

return array(
    'defaultController' => 'login',
    'basePath' => $appPath . '/backend',
    'name' => 'phpRecDB Administration Panel',
    'onBeginRequest'=>array('DbMigrator', 'checkDbState'), //check db version on start up
    'preload' => array(
        'bootstrap',
    ),
    'components' => array(
        'user' => array(
            'allowAutoLogin' => false,
            'loginUrl' => array('login/login'),
            'class' => 'WebUser',
            'authExpires' => 20 /* minutes */ * 60 /* seconds */, //means auto log out after 20 min
        ),
        'recordManager' => array('class' => 'RecordManager'),
        'signatureManager' => array ('class' => 'SignatureManager'),
        'screenshotManager' => array('class' => 'ScreenshotManager'),
        'dbCleaner' => array('class' => 'DbCleaner'),
        'dbMigrator' => array('class' => 'DbMigrator'),
        'bootstrap' => array(
            'class' => 'ext.bootstrap.components.Bootstrap',
            'responsiveCss' => false,
        ),
    ),
    'modules' => array(
        'gii' => array(
            'class' => 'system.gii.GiiModule',
            'password' => 'pick',
            'generatorPaths' => array(
                'bootstrap.gii'
            ),
        ),
    ),
    'import' => array(
        'application.components.*',
        'application.components.user.*',
        'application.models.*',
        'application.models.orm.*',
    ),
    'params' => require(dirname(__FILE__) . '/params.php'),
);
