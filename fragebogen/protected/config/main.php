<?php

return array(
    'name' => 'Fragebogen',
    // autoloading model and component classes
    'import' => array(
        'application.models.*',
        'application.components.*',
    ),
    'defaultController' => 'fragebogen',
    // application components
    'components' => array(
        'db' => array(
            'connectionString' => 'mysql:host=localhost;dbname=fragebogen',
            'emulatePrepare' => true,
            'username' => 'root',
            'password' => 'password',
            'charset' => 'utf8',
            'tablePrefix' => 'tbl_',
        ),
    ),
    'modules' => array(
        'gii' => array(
            'class' => 'system.gii.GiiModule',
            'password' => 'pick',
        ),
    ),
);
?>