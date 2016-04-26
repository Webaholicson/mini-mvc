<?php
$routes = [];

$routes['/'] = [
    'controller' => '\Webaholicson\Minimvc\Page\Controller\Index',
    'view' => '\Webaholicson\Minimvc\Page\View\Index'
];

$routes['/search'] = [
    'controller' => '\Webaholicson\Minimvc\Page\Controller\Search'
];

$routes['no_route'] = [
    'controller' => '\Webaholicson\Minimvc\Page\Controller\NoRoute'
];