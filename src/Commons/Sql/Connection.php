<?php

/**
 * =============================================================================
 * @file        Commons/Sql/Connection.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *              Copyright (C) 2009-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

namespace Commons\Sql;

use Commons\Sql\Driver\DriverInterface;
use Commons\Sql\Exception;
use Commons\Sql\RecordTable;

class Connection
{

    protected $_driver;
    protected $_tables = array();
    
    /**
     * Setup connection object.
     * @param Commons\Sql\Driver\DriverInterface $driver
     */
    public function __construct(DriverInterface $driver = null)
    {
        $this->_driver = $driver;
    }
    
    /**
     * Set driver instance.
     * @param Commons\Sql\Driver\DriverInterface $driver
     * @return Commons\Sql\Connection
     */
    public function setDriver(DriverInterface $driver)
    {
        $this->_driver = $driver;
        return $this;
    }
    
    /**
     * Get driver instance.
     * @throws Commons\Sql\Exception
     * @return Commons\Sql\Driver\DriverInterface
     */
    public function getDriver()
    {
        if (!$this->_driver) {
            throw new Exception("Driver is not set!");
        }
        return $this->_driver;
    }
    
    /**
     * Check if driver is set.
     * @return boolean
     */
    public function hasDriver()
    {
        return isset($this->_driver);
    }
    
    /**
     * Connect to the database.
     * @param array $options
     * @return Commons\Sql\Connection
     */
    public function connect($options = null)
    {
        $this->getDriver()->connect($options);
        return $this;
    }
    
    /**
     * Disconnect from the database.
     * @return Commons\Sql\Connection
     */
    public function disconnect()
    {
        $this->getDriver()->disconnect();
        return $this;
    }
    
    /**
     * Check if connected.
     * @return boolean
     */
    public function isConnected()
    {
        return $this->getDriver()->isConnected();
    }
    
    /**
     * Prepare a statement.
     * @param string $rawSql
     * @return Commons\Sql\Statement\StatementInterface
     */
    public function prepareStatement($rawSql)
    {
        return $this->getDriver()->prepareStatement($rawSql);
    }
    
    /**
     * Begin transaction.
     * @return Commons\Sql\Connection
     */
    public function begin()
    {
        $this->getDriver()->begin();
        return $this;
    }
    
    /**
     * Commit transaction.
     * @return Commons\Sql\Connection
     */
    public function commit()
    {
        $this->getDriver()->commit();
        return $this;
    }
    
    /**
     * Rollback transaction.
     * @return Commons\Sql\Connection
     */
    public function rollback()
    {
        $this->getDriver()->rollback();
        return $this;
    }
    
    /**
     * Check if in transaction.
     * @return boolean
     */
    public function inTransaction()
    {
        return $this->getDriver()->inTransaction();
    }
    
    /**
     * Create a new query.
     * @return Query
     */
    public function createQuery()
    {
        return new Query($this);
    }
    
    /**
     * Set table.
     * @param string $recordName
     * @param Commons\Sql\RecordTable $table
     * @return Commons\Sql\Connection
     */
    public function setTable($recordName, RecordTable $table)
    {
        $className = $recordName.'Table';
        $this->_tables[$className] = $table;
        return $this;
    }
    
    /**
     * Get table.
     * @param string $recordName
     * @return Commons\Sql\RecordTable
     */
    public function getTable($recordName)
    {
        $className = $recordName.'Table';
        if (!isset($this->_tables[$className])) {
            if (class_exists($className)) {
                $table = new $className($this);
            } else {
                $table = new RecordTable($this);
            }
            $this->_tables[$className] = $table;
        }
        return $this->_tables[$className];
    }
    
}
