<?php
$service = array();

$services['Webaholicson\Minimvc\Core\App'] = '\Webaholicson\Minimvc\Core\App';
$services['Webaholicson\Minimvc\Core\Config'] = '\Webaholicson\Minimvc\Core\Config';
$services['Webaholicson\Minimvc\Core\Router'] = '\Webaholicson\Minimvc\Core\Router';
$services['Webaholicson\Minimvc\Core\Request'] = '\Webaholicson\Minimvc\Core\Request';
$services['Webaholicson\Minimvc\Core\Response'] = '\Webaholicson\Minimvc\Core\Response';
$services['Webaholicson\Minimvc\Core\View\ViewInterface'] = '\Webaholicson\Minimvc\Core\View\Template';
$services['Webaholicson\Minimvc\Core\Context\ContextInterface'] = '\Webaholicson\Minimvc\Core\App\Context';
$services['Webaholicson\Minimvc\Core\Controller\ControllerInterface'] = '\Webaholicson\Minimvc\Core\Controller\Index';