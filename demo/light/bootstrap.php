<?php

$rootDirPath = dirname(dirname(dirname(__FILE__)));
defined('ROOT_PATH') || define('ROOT_PATH', $rootDirPath);

date_default_timezone_set('UTC');
error_reporting(E_ALL);
ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);

require_once $rootDirPath.'/src/Commons/Autoloader/DefaultAutoloader.php';

Commons\Autoloader\DefaultAutoloader::addIncludePath($rootDirPath.'/src');

Commons\Autoloader\DefaultAutoloader::init();

$logger = new Commons\Log\Logger;
$logger->addWriter(new Commons\Log\Writer\SyslogWriter());
Commons\Log\Log::setLogger($logger);
