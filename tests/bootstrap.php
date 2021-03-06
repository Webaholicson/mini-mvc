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
$paths['unit'] = BP.DS.'unit';
$paths['app'] = BP.DS.'..'.DS.'app';

$appPath = implode(PS, $paths);
set_include_path($appPath . PS . get_include_path());

if (file_exists('../vendor/autoload.php')) {
    include '../vendor/autoload.php';
}

spl_autoload_register(function($className){
    $filePath = str_replace(
            array(
                'Webaholicson'.DS.'Minimvc'.DS.'Tests'.DS,
                'Webaholicson'.DS.'Minimvc'.DS
            ), 
            array('', ''), 
            strtr(
                ltrim($className, '\\'),
                array(
                    '\\' => DS,
                    '_'  => DS
                )
            )
        );

        include_once $filePath . '.php';
});