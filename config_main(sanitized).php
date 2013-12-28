<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
    'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
    // uncomment the following to change the default controller from 'site' to whatever
    'defaultController'=>'game',
    'name'=>'Sudo Sudoku (p4.websandbox.biz)',

    // preloading 'log' component
    'preload'=>array('log'),

    // autoloading model and component classes
    'import'=>array(
        'application.models.*',
        'application.components.*',
        'application.modules.user.models.*',        // required for yii-user
        'application.modules.user.components.*',    // required for yii-user
    ),

    // application modules -
    'modules'=>array(
        // uncomment the following to enable the Gii tool
        /*
        'gii'=>array(
            'class'=>'system.gii.GiiModule',
            'password'=>'<some-password>',
            // If removed, Gii defaults to localhost only. Edit carefully to taste.
            'ipFilters'=>array('127.0.0.1','::1'),
        ),
        */
        // the following settings are used by yii-user -
        'user'=>array(
            # encrypting method (php hash function)
            'hash' => 'md5',

            # send activation email
            'sendActivationMail' => true,

            # allow access for non-activated users
            'loginNotActiv' => false,

            # activate user on registration (only sendActivationMail = false)
            'activeAfterRegister' => false,

            # automatically login from registration
            'autoLogin' => true,

            # registration path
            'registrationUrl' => array('/user/registration'),

            # recovery password path
            'recoveryUrl' => array('/user/recovery'),

            # login form path
            'loginUrl' => array('/user/login'),

            # page after login
            'returnUrl' => array('/user/profile'),

            # page after logout
            'returnLogoutUrl' => array('/user/login'),
        ),

    ),

    // application components -
    'components'=>array(
        // required by yii-user -
        'user'=>array(
            // enable cookie-based authentication
            'class' => 'WebUser',
        ),
        // uncomment the following to enable URLs in path-format (sets CUrlManager properties)
        /* */
        'urlManager'=>array(
            'urlFormat'=>'path',
            'urlSuffix'=>'.html',
            'showScriptName'=>false,  // set to false to hide index.php
            'rules'=>array(
                //'<page:\w+>' => 'site/<page>',                                    // successfully hides 'site' - comment out to access /gii
                '<controller:\w+>'=>'<controller>/',                                // default action (TODO: necessary?)
                '<controller:\w+>/<id:\d+>'=>'<controller>/view',                   // distribution config
                '<controller:\w+>/<id:\d+>/<title>'=>'<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',  // distribution config
                '<controller:\w+>/<action:\w+>'=>'<controller>/<action>',           // distribution config
            ),
        ),
        /* */
        // the following maps the jQuery coreScript assets to the Google CDN versions to use for this app - jlinson
        'clientScript' => array(
            'scriptMap' => array(
                'jquery.js' => '//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.js',
                'jquery.min.js' => '//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js',
                'jquery-ui.min.js' => '//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js',
            ),
        ),
        // uncomment the following to use a SQLite database
        /*
        'db'=>array(
            'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
        ),
        */
        // uncomment the following to use a MySQL database
        /* */
        'db'=>array(
            'connectionString' => 'mysql:host=localhost;dbname=websandb_p4_websandbox_biz',
            'emulatePrepare' => true,
            'tablePrefix' => 'tbl_',        // required to complete yii-user migration - jbl
            'username' => '<some-username>',
            'password' => '<some-password>',
            'charset' => 'utf8',
        ),
        /* */
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
                /* TODO: if (YII_DEBUG) - how do you dynamically add to array
                array(
                    'class'=>'CWebLogRoute',
                ),
                */
            ),
        ),
    ),

    // application-level parameters that can be accessed
    // using Yii::app()->params['paramName']
    'params'=>array(
        // this is used in contact page
        'adminEmail'=>'jlinson@g.<some-college>.edu',

        // this is used in AR models to get table prefix (coordinate with components[db] array above).
        'tablePrefix' => 'tbl_',
    ),
);