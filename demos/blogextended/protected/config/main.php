<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'blog',
	'defaultController'=>'post',

	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
		'application.extensions.*',
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>require(dirname(__FILE__).'/params.php'),

	// application components
	'components'=>array(
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CWebLogRoute',
					'levels'=>'error, warning, trace',
				),
			),
		),
		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
			// force 401 HTTP error if authentication needed
			'loginUrl'=>null,
		),
                'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=blog',
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => '',
			'charset' => 'utf8',
			'tablePrefix' => '',
		),
		'urlManager'=>array(
			'showScriptName'=>false, // enable this (false) when .htaccess takes effect on the host
			'urlFormat'=>'path',
			'rules'=>array(
				'tag/<tag>'=>'post/list',
				'posts'=>'post/list',
				'post/<id:\d+>'=>'post/show',
				'post/update/<id:\d+>'=>'post/update',
				'date/<time:\d+>'=>'post/PostedOnDate',
				'month/<time:\d+>/<pnc:p|c|n>'=>'post/PostedInMonth',
				'rss.xml'=>'post/feed',
			),
		),
                'widgetCollapse'=>array(
			'class'=>'WidgetCollapse',
			'enable'=>true,
		),
                'highslide'=>array(
			'class'=>'Highslide',
			'enable'=>true,
		),
		'timer'=>array(
			'class'=>'Timer',
		),
		'clientScript'=>array(
				      /*
				      'class'=>'application.components.ExtendedClientScript',
				      'combineFiles'=>true,
				      'compressCss'=>true,
				      'compressJs'=>true,
				      */
		),
	),
);