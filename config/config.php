<?php
use \Webaholicson\Minimvc\Core\Object;

$config = array();

$config['general'] = new Object(array(
  'base_url' => 'http://localhost/mini-mvc',
  'base_uri' => '/mini-mvc',
  'template_engine' => 'phtml'
));

$config['request'] = new Object(array(
  'baseUri' => $config['general']->get('base_uri'),
  'host' => $_SERVER['SERVER_NAME'],
  'scheme' => isset($_SERVER['HTTPS']) ? 'https' : 'http',
  'path' => $_SERVER['REQUEST_URI'],
  'method' => $_SERVER['REQUEST_METHOD'],
  'query' => $_SERVER['QUERY_STRING'],
));

$config['database'] = new Object(array(
  'adapter' => 'mongodb',
  'host' => '127.0.0.1',
  'port' => 27001,
  'database' => '',
  'username' => '',
  'password' => ''
));
