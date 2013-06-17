<?php

/**
 * =============================================================================
 * @file       Commons/Sql/Utils/PgsqlUtils.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *             Copyright (C) 2009-2013 PHP Commons Contributors
 *             All rights reserved.
 *             www.phpcommons.com
 * =============================================================================
 */

namespace Commons\Sql\Utils;

use Commons\Sql\Exception;

class PgsqlUtils
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
        $desc = "host={$host} port={$port} user={$username} password={$password}";
        $conn = pg_connect($desc);
        if (!$conn) {
            throw new Exception(pg_last_error());
        }
        
        $result = pg_query($conn, $query);
        if (!$result) {
            throw new Exception(pg_last_error($conn));
        }
        
        pg_close($conn);
    }
}
