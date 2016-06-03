<?php
$config = [];

$config['general'] = [
    'base_url' => 'http://mini-mvc.localhost.com',
    'base_uri' => '/',
    'template_engine' => 'phtml',
    'secret' => '123456789'
];

$config['request'] = [
    'baseUri' => $config['general']['base_uri'],
    'host' => $_SERVER['SERVER_NAME'],
    'scheme' => isset($_SERVER['HTTPS']) ? 'https' : 'http',
    'path' => $_SERVER['REQUEST_URI'],
    'method' => $_SERVER['REQUEST_METHOD'],
    'query' => $_SERVER['QUERY_STRING'],
    'referrer' => isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '' ,
];

$config['database']['default'] = [
    'adapter' => 'mongodb',
    'host' => '127.0.0.1',
    'port' => 27001,
    'database' => '',
    'username' => '',
    'password' => ''
];

$config['session'] = [
    'storage' => 'Webaholicson\Minimvc\Core\Session\File',
    'storage_dir' => 'session',
    'lifetime' => time() + (60*15),
    'path' => '/',
    'domain' => '.locallhost.com',
    'secure' => false,
    'http_only' => true
];