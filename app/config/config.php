<?php

define('DS', DIRECTORY_SEPARATOR);
define('APP_PATH', realpath(dirname(__FILE__)) . DS . '..' . DS );
define('VIEWS_PATH', APP_PATH . 'views' . DS);
define('temp_PATH', APP_PATH . 'template' . DS);
define('CONTROLLERS_PATH', APP_PATH . 'controllers' . DS);
define('LIB_PATH', APP_PATH . 'lib' . DS);
define('language_PATH', APP_PATH . 'language' . DS);
define('MODELS_PATH', APP_PATH . 'models' . DS);
define('SESSION_PATH', LIB_PATH . 'sessions');
date_default_timezone_set ('Africa/Cairo' );

defined('DATABASE_HOST_NAME')             ? null : define('DATABASE_HOST_NAME' , 'localhost');
defined('DATABASE_USER_NAME')             ? null : define('DATABASE_USER_NAME' , 'root');
defined('DATABASE_PASSWORD')              ? null : define('DATABASE_PASSWORD' , '');
defined('DATABASE_DB_NAME')               ? null : define('DATABASE_DB_NAME' , 'store');
defined('DATABASE_PORT_NUMBER')           ? null : define('DATABASE_PORT_NUMBER' , '3306');
defined('DATABASE_CONN_DRIVER')           ? null : define('DATABASE_CONN_DRIVER' , '1');


defined('defaultLanguage')                ? null : define('defaultLanguage' , 'ar');

// session config

defined('Session_Name')                ? null : define('Session_Name' , 'sess_store');
defined('Session_Domain')                ? null : define('Session_Domain' , '.mymvc.com');
defined('SESSION_LIFETIME')                ? null : define('SESSION_LIFETIME' , '0');




