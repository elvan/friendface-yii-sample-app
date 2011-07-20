<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
  'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
  'name'=>'Friendface',
  'theme' => 'tutorialzine1',

  // preloading 'log' component
  'preload'=>array('log'),

  // autoloading model and component classes
  'import'=>array(
    'application.models.*',
    'application.components.*',
    'application.extensions.*',
  ),

  'modules'=>array(
    // uncomment the following to enable the Gii tool
    'gii'=>array(
      'class'=>'system.gii.GiiModule',
      'password'=>'admin',
       // If removed, Gii defaults to localhost only. Edit carefully to taste.
      'ipFilters'=>array('127.0.0.1','::1'),
    ),
  ),

  // application components
  'components'=>array(
    'user'=>array(
      // enable cookie-based authentication
      'allowAutoLogin'=>true,
    ),
    // uncomment the following to enable URLs in path-format
    'urlManager'=>array(
      'urlFormat'=>'path',
      'showScriptName' => false,
      'rules'=>array(
        'contact' => 'site/contact',
        'about' => 'site/about',
        'help' => 'site/help',
        'signin' => 'site/login',
        'signout' => 'site/logout',
        'signup' => 'user/create',
        'u/<uid:\w+>' => 'user/view',
        'profile/<uid:\d+>/post/<pid:\d+>' => 'post/view',
        'profile/<id:\d+>/followers' => 'profile/followers',
        'profile/<id:\d+>/following' => 'profile/following',
        'settings' => 'user/view',
        '<controller:\w+>/<id:\d+>'=>'<controller>/view',
        '<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
        '<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
      ),
    ),
    /*
    'db'=>array(
      'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
    ),
    */
    // uncomment the following to use a MySQL database
    'db'=>array(
      'connectionString' => 'mysql:host=localhost;dbname=friendface_dev',
      'emulatePrepare' => true,
      'username' => 'root',
      'password' => '',
      'charset' => 'utf8',
      'tablePrefix' => 'tbl_',
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
  ),

  // application-level parameters that can be accessed
  // using Yii::app()->params['paramName']
  'params'=>array(
    // this is used in contact page
    'adminEmail'=>'webmaster@example.com',
  ),
);
