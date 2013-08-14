<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
Yii::setPathOfAlias('editable', dirname(__FILE__).'/../extensions/x-editable');
Yii::setPathOfAlias('chartjs', dirname(__FILE__).'/../extensions/yii-chartjs');

return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'FEC Administration',
    'language'         => 'de',

	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
        'application.components.enums.*',
        'application.modules.acl.components.*',
        'application.modules.acl.models.behaviors.*',
        'application.modules.acl.models.*',
        'application.modules.user.models.*',
        'application.modules.user.components.*',
        'ext.quickdlgs.*',
        'editable.*',
	),

	'modules'=>array(
		// uncomment the following to enable the Gii tool
		/*'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'Enter Your Password Here',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
		),*/        
		'user'=>array(
            'hash' => 'ripemd160',
            'sendActivationMail' => true,
            'loginNotActiv' => false,
            'activeAfterRegister' => false,
            'autoLogin' => true,
            'registrationUrl' => array('/user/registration'),
            'recoveryUrl' => array('/user/recovery'),
            'loginUrl' => array('/user/login'),
            'returnUrl' => array('/user/profile'),
            'returnLogoutUrl' => array('/user/login'),
		),
        'acl'=>array(
            'strategy_config' => array(
                'prefix' => 'Pm',
                'strictMode' => false,
                'guestGroup' => 'Guest',
                'virtualObjects' => array(),
                'virtualObjectPattern' => '{ident}_virtual',
                'virtualObjectCallback' => NULL,
                'enableBusinessRules' => false,
                'lookupBusinessRules' => 'all',
                'enablePermissionChangeRestriction' => false,
                'enableSpecificPermissionChangeRestriction' => false,
                'enableRelationChangeRestriction' => false,
                'generalPermissions' => array('create'),
                'autoPermissions' => '*',
                'enableGeneralPermissions' => false,
                'autoJoinGroups' => array(
                    'aro' => array('All'),
                    'aco' => array('All')
                ),
                'caching' => array(
                  'collection' => 0,
                  'action'     => 0,
                  'permission' => 0,
                  'aclObject' => 0,
                  'aroObject' => 0,
                  'structureCache' => 0,
                  'cacheComponent' => 'cache'
                ),
            ),    
        ),
	),

	// application components
	'components'=>array(
		'user'=>array(
			'class' => 'WebUser',
			'allowAutoLogin'=>true,
		),
		// uncomment the following to enable URLs in path-format

		'urlManager'=>array(
			'urlFormat'=>'path',
			'rules'=>array(
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),

		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=fec',
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => '',
			'charset' => 'utf8',
		),
		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'site/error',
		),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
				// uncomment the following to show log messages on web pages
				/*
				array(
					'class'=>'CWebLogRoute',
				),
				*/
			),
		),
        //X-editable config
        'editable' => array(
            'class'     => 'editable.EditableConfig',
            'form'      => 'jqueryui',        //form style: 'bootstrap', 'jqueryui', 'plain'
            'mode'      => 'inline',            //mode: 'popup' or 'inline'
            'defaults'  => array(              //default settings for all editable elements
                'emptytext' => Yii::t('config','Klicken zum bearbeiten'),
            )
        ),
        'chartjs'=>array( 'class' => 'chartjs.components.ChartJs', ),
    ),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'michael.jo.kling@gmail.com',
        'cronSecret'=>'23611742',
	),
);