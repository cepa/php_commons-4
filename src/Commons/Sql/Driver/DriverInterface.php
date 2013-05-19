<?php

/**
 * =============================================================================
 * @file        Commons/Sql/Driver/DriverInterface.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *              Copyright (C) 2009-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

namespace Commons\Sql\Driver;

use Commons\Sql\Statement\StatementInterface;

interface DriverInterface
{
    
    /**
     * Get name of the driver.
     * @return string
     */
    public function getDatabaseType();
    
    /**
     * Connect to the database.
     * @param array $options
     * @throws Exception
     */
    public function connect($options = null);
    
    /**
     * Disconnect from the database.
     * @throws Exception
     */
    public function disconnect();
    
    /**
     * Check if driver is connected.
     * @return boolean
     */
    public function isConnected();
    
    /**
     * Prepare an sql query statement.
     * @param string $rawSql
     * @throws Exception
     * @return StatementInterface
     */
    public function prepareStatement($rawSql);
    
    /**
     * Begin transaction.
     * @throws Exception
     */
    public function begin();
    
    /**
     * Commit transaction.
     * @throws Exception
     */
    public function commit();
    
    /**
     * Rollback transaction.
     * @throws Exception
     */
    public function rollback();
    
    /**
     * Check if driver is in transaction.
     * @return boolean
     */
    public function inTransaction();
    
}
