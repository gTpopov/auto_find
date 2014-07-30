<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Auto Find',
    'defaultController' => 'index',
    'sourceLanguage'    => 'en',
    'language'          => 'ru',

	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
		'application.users.importEngine.*',
	),

	'modules'=>array(
		// uncomment the following to enable the Gii tool
		'users',
        'admin',
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'123',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
		),

	),

	// application components
	'components'=>array(
        'request'=> array('class'=>'DLanguageHttpRequest'),
        'stemru' => array('class'=>'Stemru'),
        'stopwr' => array('class'=>'STOPWords'),
        'mailer' => array('class'=>'PHPMailer'),
        'geo'    => array('class'=>'GEOPlugin'),
        'export' => array('class'=>'ExportToexcel'),
        //'cache'  => array('class'=>'system.caching.CFileCache'),
		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
            'loginUrl'=>'/enter',
		),
		// uncomment the following to enable URLs in path-format

		'urlManager'=>array(
            'class'     => 'DLanguageUrlManager',
			'urlFormat' => 'path',
            'urlSuffix' => '.html',
			'showScriptName' => false,
			'rules'=>array(
                '/load'=>'/users/default/index',
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),
        /*
		'db'=>array(
			'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
		),*/
		// uncomment the following to use a MySQL database
		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=pricezapch',
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => '',
			'tablePrefix'=>'',
			'attributes'=>array(
				PDO::MYSQL_ATTR_LOCAL_INFILE =>true,
			),
			'charset' => 'utf8',
		),
		'errorHandler'=>array(
			// use 'site/error' action to display errors
            'errorAction'=>'/error/index',
		),
        'log'=>array(
            'class'=>'CLogRouter',
            'routes'=>array(
                array(
                    'class'=>'CFileLogRoute',
                    'levels'=>'error, warning',
                ),
                /*array(
                    'class'=>'CWebLogRoute',
                ),*/
            ),
        ),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'webmaster@example.com',
        'translatedLanguages'=>array(
            'ru'=>'Русский',
            'en'=>'English',
            'de'=>'Deutsch',
        ),
        'defaultLanguage'=>'ru',
	),
);