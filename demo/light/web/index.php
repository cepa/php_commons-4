<?php

use Commons\Autoloader\DefaultAutoloader;
use Commons\Light\Dispatcher\HttpDispatcher;
use Commons\Light\Route\StaticRoute;
use Commons\Light\Route\RegexRoute;
use Commons\Light\Route\RestRoute;

require_once dirname(dirname(__FILE__)).'/bootstrap.php';

DefaultAutoloader::addIncludePath(ROOT_PATH.'/demo/light/src');

$routes = array(
    'custom/simple-route' => new StaticRoute(
        'simple-route.html', 
        array('controller' => 'custom', 'action' => 'simple-route')
    ),
                
    'custom/regex-route' => new RegexRoute(
        'regex,(.*),(.*).html',
        array('controller' => 'custom', 'action' => 'regex-route'),
        array('x', 'y'),
        'regex,%d,%s.html'
    ),
		
	'rest/get-user' => new RestRoute(
	    'GET', 'users/(.*)',
        array('controller' => 'rest', 'action' => 'get-user'),
	    array('user_id')
	),
                
    'rest/post-user' => new RestRoute(
        'POST', 'users/(.*)',
        array('controller' => 'rest', 'action' => 'post-user'),
        array('user_id')
    ),
    
    'rest/put-user' => new RestRoute(
        'PUT', 'users/(.*)',
        array('controller' => 'rest', 'action' => 'put-user'),
        array('user_id')
    ),
    
    'rest/delete-user' => new RestRoute(
        'DELETE', 'users/(.*)',
        array('controller' => 'rest', 'action' => 'delete-user'),
        array('user_id')
    ),
    
);

$dispatcher = new HttpDispatcher();
$dispatcher
    ->setBaseUri('/php_commons-4/demo/light/web/')
    ->setModuleNamespace('default', 'Demo\\Controller\\')
    ->addRoutes($routes)
    ->dispatch();
