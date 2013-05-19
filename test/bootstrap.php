<?php

/**
 * =============================================================================
 * @file        bootstrap.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright PHP Commons
 *              Copyright (C) 2009-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

$rootDirPath = dirname(dirname(__FILE__));
defined('ROOT_PATH') || define('ROOT_PATH', $rootDirPath);

date_default_timezone_set('UTC');
error_reporting(E_ALL);
ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);

$config = array(
    'DATABASE_DRIVER'	=> 'mysql',
    'DATABASE_HOST'		=> 'localhost',
    'DATABASE_PORT'		=> 3306,
    'DATABASE_USERNAME' => 'root',
    'DATABASE_PASSWORD' => ''
);

/*
 * Continous Integration.
 */
$ciConfig = strtolower(getenv('CONFIG'));
$dbHost = 'test-'.$ciConfig;
if (strstr($ciConfig, 'mysql')) {
    $config['DATABASE_DRIVER']    = 'mysql';
    $config['DATABASE_HOST']      = $dbHost;
    $config['DATABASE_PORT']      = 3306;
    $config['DATABASE_USERNAME']  = 'root';
    $config['DATABASE_PASSWORD']  = '';
} else if (strstr($ciConfig, 'postgresql')) {
    $config['DATABASE_DRIVER']    = 'pgsql';
    $config['DATABASE_HOST']      = $dbHost;
    $config['DATABASE_PORT']      = 5432;
    $config['DATABASE_USERNAME']  = 'postgres';
    $config['DATABASE_PASSWORD']  = 'postgres';
}

foreach ($config as $name => $value) {
    if (!defined($name)) {
        define($name, $value);
    }
}

require_once $rootDirPath.'/src/Commons/Autoloader/DefaultAutoloader.php';

Commons\Autoloader\DefaultAutoloader::addIncludePath($rootDirPath.'/src');
Commons\Autoloader\DefaultAutoloader::addIncludePath($rootDirPath.'/test');

Commons\Autoloader\DefaultAutoloader::init();

$logger = new Commons\Log\Logger;
$logger->addWriter(new Commons\Log\Writer\SyslogWriter());
Commons\Log\Log::setLogger($logger);

class Bootstrap
{

    protected function __construct() {}

    public static function getDatabaseOptions($database = null)
    {
        return array(
            'database'	=> $database,
            'driver'	=> DATABASE_DRIVER,
            'host'	    => DATABASE_HOST,
            'port'		=> DATABASE_PORT,
            'username'  => DATABASE_USERNAME,
            'password'  => DATABASE_PASSWORD
        );
    }

    public static function createDatabase()
    {
        $database = 'test_'.\Commons\Utils\RandomUtils::randomString(10);
        switch (DATABASE_DRIVER) {
            case 'mysql':
                \Commons\Sql\Utils\MysqlUtils::createDatabase(
                    $database,
                    DATABASE_HOST,
                    DATABASE_PORT,
                    DATABASE_USERNAME,
                    DATABASE_PASSWORD);
                break;
            case 'pgsql':
                \Commons\Sql\Utils\PgsqlUtils::createDatabase(
                    $database,
                    DATABASE_HOST,
                    DATABASE_PORT,
                    DATABASE_USERNAME,
                    DATABASE_PASSWORD);
                break;
            default: throw new \RuntimeException();
        }
        return $database;
    }

    public static function dropDatabase($database)
    {
        switch (DATABASE_DRIVER) {
            case 'mysql':
                \Commons\Sql\Utils\MysqlUtils::dropDatabase(
                    $database,
                    DATABASE_HOST,
                    DATABASE_PORT,
                    DATABASE_USERNAME,
                    DATABASE_PASSWORD);
                break;
            case 'pgsql':
                \Commons\Sql\Utils\PgsqlUtils::dropDatabase(
                    $database,
                    DATABASE_HOST,
                    DATABASE_PORT,
                    DATABASE_USERNAME,
                    DATABASE_PASSWORD);
                break;
            default: throw new \RuntimeException();
        }
    }

    public static function abort(\Exception $e = null)
    {
        \Commons\Utils\TestUtils::abort($e);
    }

}
