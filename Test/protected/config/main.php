<?php

Yii::setPathOfAlias('screenshots', dirname(__FILE__).'/../../screenshots');

return array(
    'name' => 'phpRecDB',
    'preload' => array(
        'bootstrap',
    ),
    'components' => array(
        'bootstrap' => array(
            'class' => 'ext.bootstrap.components.Bootstrap',
            'responsiveCss' => false,
        ),
        
          'db'=>array(
            'connectionString'=>'mysql:host=localhost;dbname=fileupload',
            'username'=>'root',
            'password'=>'',
            'charset'=>'utf8',
        ),
        
    ),
    'import' => array(
        'application.models.*',
    ),
);