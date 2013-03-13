<?php

date_default_timezone_set('UTC');
error_reporting(E_ALL);
ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);

$rootDir = dirname(dirname(__FILE__));
require_once $rootDir.'/src/Commons/Autoloader/DefaultAutoloader.php';

Commons\Autoloader\DefaultAutoloader::addIncludePath($rootDir.'/src');
Commons\Autoloader\DefaultAutoloader::addIncludePath($rootDir.'/test');
Commons\Autoloader\DefaultAutoloader::init();


