<?php

// change the following paths if necessary
require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR . 'phpRecDB'.DIRECTORY_SEPARATOR.'app' . DIRECTORY_SEPARATOR . 'common' . DIRECTORY_SEPARATOR . 'libs' . DIRECTORY_SEPARATOR . 'yiiframework' . DIRECTORY_SEPARATOR . 'yii.php');

$config=dirname(__FILE__).'/protected/config/main.php';

// remove the following lines when in production mode
defined('YII_DEBUG') or define('YII_DEBUG',true);
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);


Yii::createWebApplication($config)->run();
