<?php
defined('YII_DEBUG') or define('YII_DEBUG', true);

// include Yii bootstrap file
require_once(dirname(__FILE__).'/../phpRecDB/app/common/libs/yiiframework/yii.php');

$config=dirname(__FILE__).'/protected/config/main.php';

Yii::createWebApplication($config)->run();
