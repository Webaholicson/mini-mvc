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

// Include services, configuration and routes
include 'config/services.php';
include 'config/config.php';
include 'config/routes.php';

// Initialize and run the app
include 'Core/Services.php';
include 'Core/Bootstrap.php';
$manager = new \Webaholicson\Minimvc\Core\Services($services);
$bootstrap = new \Webaholicson\Minimvc\Core\Bootstrap($manager);
$app = $bootstrap->init(array(
    'routes' => $routes,
    'config' => $config,
    'request' => $config['request']
));
$app->run();
