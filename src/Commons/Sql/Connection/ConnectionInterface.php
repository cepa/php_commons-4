<?php

/**
 * =============================================================================
 * @file        Commons/Sql/Connection/ConnectionInterface.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *              Copyright (C) 2009-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

namespace Commons\Sql\Connection;

use Commons\Sql\Query;
use Commons\Sql\RecordTable;
use Commons\Sql\Driver\DriverInterface;

interface ConnectionInterface
{
    
    /**
     * Set driver.
     * @param DriverInterface $driver
     * @param string $id Instance identifier.
     * @return ConnectionInterface
     */
    public function setDriver(DriverInterface $driver, $id = null);
    
    /**
     * Get driver.
     * @param string $id identifier
     * @return ConnectionInterface
     */
    public function getDriver($id = null);
    
    /**
     * Has driver.
     * @param string $id ConnectionInterface
     * @return boolean
     */
    public function hasDriver($id = null);
    
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
     * Is connected.
     * @return boolean
     */
    public function isConnected();
    
    /**
     * Prepare sql statement.
     * @param string $rawSql
     * @param mixed $options
     * @return StatementInterface
     */
    public function prepareStatement($rawSql, $options = null);
    
    /**
     * Begin transaction.
     * @return ConnectionInterface
     */
    public function begin();
    
    /**
     * Commit transaction.
     * @return ConnectionInterface
     */
    public function commit();
    
    /**
     * Rollback transaction.
     * @return ConnectionInterface
     */
    public function rollback();
    
    /**
     * Is in transaction.
     * @return boolean
     */
    public function inTransaction();
    
    /**
     * Create sql query.
     * @return Query
     */
    public function createQuery();
    
    /**
     * Set model table.
     * @param string $recordName
     * @param RecordTable $table
     * @return ConnectionInterface
     */
    public function setTable($recordName, RecordTable $table);
    
    /**
     * Get model table.
     * @param string $recordName
     * @return RecordTable
     */
    public function getTable($recordName);
    
}
