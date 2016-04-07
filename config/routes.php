<?php
$routes = array();

$routes['/'] = array(
  'controller' => 'Webaholicson\Minimvc\Page\Controller\Index'
);

$routes['/search'] = array(
  'controller' => 'Webaholicson\Minimvc\Page\Controller\Search'
);

$routes['no_route'] = array(
  'controller' => 'Webaholicson\Minimvc\Page\Controller\NoRoute'
);
