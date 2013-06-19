<?php

/**
 * =============================================================================
 * @file       Commons/NoSql/Cassandra/Connection/Connection.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *             Copyright (C) 2009-2013 PHP Commons Contributors
 *             All rights reserved.
 *             www.phpcommons.com
 * =============================================================================
 */

namespace Commons\NoSql\Cassandra\Connection;

use phpcassa\Connection\ConnectionPool;
use phpcassa\ColumnFamily;

class Connection extends AbstractConnection
{
    
    private $_pool;
    private $_cfs = array();
    
    /**
     * Connect to Apache Cassandra.
     * @see \Commons\NoSql\Cassandra\Connection\ConnectionInterface::connect()
     * @param $options array(
     *     'keyspace' => '...',
     *     'servers'  => array('localhost:9160', '...')
     * )
     * @return ConnectionInterface
     */
    public function connect($options = null)
    {
        $pool = new ConnectionPool($options['keyspace'], $options['servers']);
        $this->setConnectionPool($pool);
        return $this;
    }
    
    /**
     * Disconnect.
     * @see \Commons\NoSql\Cassandra\Connection\ConnectionInterface::disconnect()
     */
    public function disconnect()
    {
        if ($this->_pool) {
            $this->getConnectionPool()->close();
        }
        return $this;
    }
    
    /**
     * Is connected?
     * @return boolean
     */
    public function isConnected()
    {
        return isset($this->_pool);
    }
    
    /**
     * Set connection pool.
     * @param ConnectionPool $pool
     * @return \Commons\NoSql\Cassandra\Connection\Connection
     */
    public function setConnectionPool(ConnectionPool $pool)
    {
        $this->_pool = $pool;
        return $this;
    }
    
    /**
     * Get connection pool.
     * @see \Commons\NoSql\Cassandra\Connection\ConnectionInterface::getConnectionPool()
     * @return ConnectionPool
     */
    public function getConnectionPool()
    {
        return $this->_pool;
    }
    
    /**
     * Set column family instance.
     * @param string $name
     * @param ColumnFamily $instance
     * @return \Commons\NoSql\Cassandra\Connection\Connection
     */
    public function setColumnFamily($name, ColumnFamily $instance)
    {
        $this->_cfs[$name] = $instance;
        return $this;
    }
    
    /**
     * Get column family instance.
     * @see \Commons\NoSql\Cassandra\Connection\ConnectionInterface::getColumnFamily()
     * @return ColumnFamily
     */
    public function getColumnFamily($name)
    {
        if (!isset($this->_cfs[$name])) {
            $this->setColumnFamily($name, new ColumnFamily($this->getConnectionPool(), $name));
        }
        return $this->_cfs[$name];
    }
    
}
