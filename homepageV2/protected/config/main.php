<?php

return array(
    'name' => 'phpRecDB',
    'aliases' => array(
        'bootstrap' => realpath(__DIR__ . '/../extensions/bootstrap'),
        'yiiwheels' => realpath(__DIR__ . '/../extensions/yiiwheels'),
    ),
    'import' => array(
        'bootstrap.helpers.TbHtml',
    ),
    'components' => array(
        'bootstrap' => array(
            'class' => 'bootstrap.components.TbApi',
        ),
        'yiiwheels' => array(
            'class' => 'yiiwheels.YiiWheels',
        ),
    ),
    'params' => require(dirname(__FILE__) . '/params.php'),
);