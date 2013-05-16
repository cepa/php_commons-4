<?php

require_once '../../bootstrap.php';

use Commons\Autoloader\DefaultAutoloader;
use Commons\Light\Dispatcher\HttpDispatcher;
use Commons\Utils\DebugUtils;

$appDir = dirname(dirname(__FILE__));
DefaultAutoloader::addIncludePath($appDir.'/src');

try {
    
    $dispatcher = new HttpDispatcher();
    $dispatcher
        ->setDefaultModule('hello', 'Hello\\Controller\\')
        ->dispatch();
    
} catch (\Exception $e) {
    DebugUtils::renderExceptionPage($e);
}
