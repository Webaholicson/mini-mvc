<?php
$config = array();

$config['general'] = array(
    'base_url' => 'http://localhost/mini-mvc',
    'base_uri' => '/mini-mvc',
    'template_engine' => 'phtml'
);

$config['request'] = array(
    'baseUri' => $config['general']['base_uri'],
    'host' => $_SERVER['SERVER_NAME'],
    'scheme' => isset($_SERVER['HTTPS']) ? 'https' : 'http',
    'path' => $_SERVER['REQUEST_URI'],
    'method' => $_SERVER['REQUEST_METHOD'],
    'query' => $_SERVER['QUERY_STRING'],
);

$config['database'] = array(
    'adapter' => 'mongodb',
    'host' => '127.0.0.1',
    'port' => 27001,
    'database' => '',
    'username' => '',
    'password' => ''
);

$config['session'] = array(
    'storage' => 'Webaholicson\Minimvc\Core\Session\File',
    'lifetime' => time() + (60*15),
    'path' => '/',
    'domain' => 'locallhost',
    'secure' => false,
    'http_only' => true
);