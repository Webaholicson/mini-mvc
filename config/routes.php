<?php
$routes = [];

$routes['/'] = [
  'controller' => '\Webaholicson\Minimvc\Page\Controller\Index'
];

$routes['/search'] = [
  'controller' => '\Webaholicson\Minimvc\Page\Controller\Search'
];

$routes['no_route'] = [
  'controller' => '\Webaholicson\Minimvc\Page\Controller\NoRoute'
];