<?php
// Path constants
define('DS', DIRECTORY_SEPARATOR);
define('PS', PATH_SEPARATOR);
define('BP', dirname(__FILE__));

// Display errors
ini_set('display_errors', 1);

// Set error reporting level
error_reporting(E_ALL | E_STRICT);

// Add include paths
$paths = array();
$paths[] = BP.DS.'app';

$appPath = implode(PS, $paths);
set_include_path($appPath . PS . get_include_path());
// Include config, routes, and services
include 'config/config.php';
include 'config/routes.php';

// Initialize and run the app
include 'Core/Bootstrap.php';
$bootstrap = new \Webaholicson\Minimvc\Core\Bootstrap();
$app = $bootstrap->init();
$app->run();
