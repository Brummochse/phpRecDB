<?php

return array(
    'components' => array(
        'db' => array(
            'connectionString' => 'mysql:host=localhost;dbname=tripkore',
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8',
        ),
    ),
    'import' => array(
        'application.components.*',
    )
);
