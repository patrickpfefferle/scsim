<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'name' => 'SCSIM',

    // path aliases
    'aliases' => array(
        'bootstrap' => realpath(__DIR__ . '/../extensions/bootstrap'), // change this if necessary
        'yiiwheels' => realpath(__DIR__ . '/../extensions/yiiwheels'), // change if necessary
    ),

    // preloading 'log' component
    'preload' => array('log'),

    // autoloading model and component classes
    'import' => array(
        'application.models.*',
        'application.components.*',
        'ext.yii-mail.YiiMailMessage',
        'bootstrap.helpers.TbHtml',
        'ext.simulation.*'
    ),

    'modules' => array(
        // uncomment the following to enable the Gii tool
        'gii' => array(
            'class' => 'system.gii.GiiModule',
            'password' => '123456',
            // If removed, Gii defaults to localhost only. Edit carefully to taste.
            'ipFilters' => array('127.0.0.1', '::1'),
            'generatorPaths' => array('bootstrap.gii'),
        ),
    ),

    // application components
    'components' => array(
        'messages' => array(
            'class' => 'CDbMessageSource',
            'sourceMessageTable' =>'source_informations',
            'translatedMessageTable'=>'translated_informations',
            'onMissingTranslation' => array(
                'MissingTranslationComponent', //class name
                'logMissingData', //function name
            ),
        ),
        'user' => array(
            // enable cookie-based authentication
            'allowAutoLogin' => true,
            'class' =>'ScsimUser'
            ),
        'random' => array(
            'class' =>'application.components.random.RandomComponent'
        ),
        'order' => array(
            'class' =>'application.components.inputData.OrderComponent'
        ),
        'productionOrder' => array(
            'class' =>'application.components.inputData.ProductionOrderComponent'
        ),
        'order' => array(
            'class' =>'application.components.inputData.OrderComponent'
        ),
        'shiftScheduling' => array(
            'class' =>'application.components.inputData.ShiftSchedulingComponent'
        ),
        'color' => array(
            'class' =>'application.components.color.ColorComponent'
        ),
        'mail' => array(
            'class' => 'ext.yii-mail.YiiMail',
            'transportType' => 'smtp',
            'transportOptions' => array(
                'host' => 'localhost',
                'username' => 'info@scsim.de',
                'password' => '123456',
                // 'port' => '465',
                // 'encryption' => 'ssl'
            ),
            'viewPath' => 'application.views.mail',
            'logging' => true,
            'dryRun' => false
        ),

        'bootstrap' => array(
            'class' => 'bootstrap.components.TbApi',
        ),
        // yiiwheels configuration
        'yiiwheels' => array(
            'class' => 'yiiwheels.YiiWheels',
        ),
        'urlManager' => array(
            'urlFormat' => 'path',
            'rules' => array(
                // REST patterns
                array('api/translate', 'pattern' => 'api/translate/<lang:\w+>', 'verb' => 'POST'),
                array('api/list', 'pattern' => 'api/<model:\w+>', 'verb' => 'GET'),
                array('api/view', 'pattern' => 'api/<model:\w+>/<id:\d+>', 'verb' => 'GET'),
                array('api/update', 'pattern' => 'api/<model:\w+>/<id:\d+>', 'verb' => 'PUT'),
                array('api/delete', 'pattern' => 'api/<model:\w+>/<id:\d+>', 'verb' => 'DELETE'),
                array('api/create', 'pattern' => 'api/<model:\w+>', 'verb' => 'POST'),
                // Other controllers
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
            ),
        ),
        'db' => array(
            'connectionString' => 'mysql:host=localhost;dbname=scsim_phoenix',
            'emulatePrepare' => true,
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8',
            'enableProfiling' => true
        ),

        'errorHandler' => array(
            // use 'site/error' action to display errors
            'errorAction' => 'site/error',
        ),
        'log' => array(
            'class' => 'CLogRouter',
            'routes' => array(
                array(
                    'class'=>'CFileLogRoute',
                    'levels'=>'error, warning, trace, info',
                    'categories'=>'simulation',
                    'logFile'=>'simulation.log',
                    'enabled'=>false,
                ),
                array(
                    'class'=>'CFileLogRoute',
                    'levels'=>'error, warning, info',
                    'logFile'=>'application.log',
                    'enabled'=>false,
                ),
                array(
                    'class'=>'CFileLogRoute',
                    'levels'=>'error, warning, trace, info',
                    'categories'=>'system.db.*',
                    'logFile'=>'db_trace.log',
                    'enabled'=>false,
                ),

                array(
                    'class' => 'CProfileLogRoute',
                    'report' => 'summary',
                    'enabled' => false,
                ),
                // uncomment the following to show log messages on web pages
                /*
                array(
                    'class'=>'CWebLogRoute',
                ),
                */
            ),
        ),
    ),

    // application-level parameters that can be accessed
    // using Yii::app()->params['paramName']
    'params' => array(
        // this is used in contact page
        'adminEmail' => 'info@scsim.de',
        'availableLanguage' => array("de", "es", "fr", "it", "ja", "pl", "ru", "el"),
    ),
);