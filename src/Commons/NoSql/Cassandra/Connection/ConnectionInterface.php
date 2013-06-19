<?php

/**
 * =============================================================================
 * @file       Commons/NoSql/Cassandra/Connection/ConnectionInterface.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *             Copyright (C) 2009-2013 PHP Commons Contributors
 *             All rights reserved.
 *             www.phpcommons.com
 * =============================================================================
 */

namespace Commons\NoSql\Cassandra\Connection;

interface ConnectionInterface
{
    
    /**
     * Connect.
     * @param mixed $options
     * @return ConnectionInterface
     */
    public function connect($options = null);
    
    /**
     * Disconnect.
     * @return ConnectionInterface
     */
    public function disconnect();
    
    /**
     * Get connection pool.
     * @return \phpcassa\Connection\ConnectionPool
     */
    public function getConnectionPool();
    
    /**
     * Get column family.
     * @param string $name
     * @return \phpcassa\ColumnFamily
     */
    public function getColumnFamily($name);
    
}
