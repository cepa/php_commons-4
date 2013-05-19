<?php

/**
 * =============================================================================
 * @file        Commons/Sql/Utils/MysqlUtils.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *              Copyright (C) 2009-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

namespace Commons\Sql\Utils;

class MysqlUtils
{

    protected function __construct() {}
    
    /**
     * Create a database.
     * @param string $database
     * @param string $host
     * @param int $port
     * @param string $username
     * @param string $password
     */
    public static function createDatabase(
        $database,
        $host,
        $port,
        $username,
        $password)
    {
        self::_executeSingleQuery("CREATE DATABASE $database", $host, $port, $username, $password);
    }
    
    /**
     * Drop a database.
     * @param string $database
     * @param string $host
     * @param int $port
     * @param string $username
     * @param string $password
     */
    public static function dropDatabase(
        $database,
        $host,
        $port,
        $username,
        $password)
    {
        self::_executeSingleQuery("DROP DATABASE IF EXISTS $database", $host, $port, $username, $password);
    }
    
    protected static function _executeSingleQuery(
        $query,
        $host,
        $port,
        $username,
        $password)
    {
        $server = $host.(isset($port) ? ':'.$port : '');
        $conn = mysql_connect($server, $username, $password);
        if (!$conn) {
            throw new Exception(mysql_error());
        }
        
        $result = mysql_query($query, $conn);
        if (!$result) {
            throw new Exception(mysql_error($conn));
        }
        
        mysql_close($conn);
    }
}
