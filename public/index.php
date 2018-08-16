<?php

//================== application Paths ==================\\
define('DS', DIRECTORY_SEPARATOR);
define('ROOT_PATH', realpath(dirname(__DIR__)));
define('PUBLIC_PATH', realpath(dirname(__FILE__)));
define('APPLICATION_PATH', ROOT_PATH . DS . 'application');
define('CONTROLLER_PATH', APPLICATION_PATH . DS . 'Controllers');
define('MODEL_PATH', APPLICATION_PATH . DS . 'Models');
define('VIEW_PATH', APPLICATION_PATH . DS . 'Views');
define('SYSTEM_PATH', ROOT_PATH . DS . 'system');
define('CORE_PATH', SYSTEM_PATH . DS . 'core');
define('HELPERS_PATH', SYSTEM_PATH . DS . 'helpers');
define('CONFIG_FILE', SYSTEM_PATH . DS . 'config.php');
define('IMAGE_PATH', '_images' . DS);


define('ENVIRONMENT', 'development');  //development || production


require_once ROOT_PATH . DS . 'vendor/autoload.php';
require_once CONFIG_FILE;

$configObj = new System\Config();
$configObj::phpVersion();
$configObj::setEnvironment();

$app = System\App::getInstance(new System\File);

$app->run();
