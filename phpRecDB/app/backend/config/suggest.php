<?php

/**
 * light weight backend config for fast autocomplete suggestion
 */

$appPath = dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..';
Yii::setPathOfAlias('common', $appPath . DIRECTORY_SEPARATOR . 'common');

return array(
    'basePath' => $appPath . '/backend',
    'components' => array(
        'user' => array(
            'allowAutoLogin' => false,
            'loginUrl' => array('login/login'),
            'class' => 'WebUser',
            'authExpires' => 20 /* minutes */ * 60 /* seconds */, //means auto log out after 20 min
        ),
        'urlManager'=>array(
            'urlFormat'=>'path',
        ),
    ),
    'import' => array(
        'common.models.orm.Artist',
        'common.models.orm.Country',
        'common.models.orm.City',
        'common.models.orm.Venue',
    ),
);
