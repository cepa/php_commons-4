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

interface DriverInterface
{
    
    /**
     * Get name of the driver.
     * @return string
     */
    public function getName();
    
    /**
     * Connect to the database.
     * @param array $options
     * @throws Commons\Sql\Exception
     */
    public function connect($options = null);
    
    /**
     * Disconnect from the database.
     * @throws Commons\Sql\Exception
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
     * @throws Commons\Sql\Exception
     * @return Commons\Sql\Statement\StatementInterface
     */
    public function prepareStatement($rawSql);
    
    /**
     * Begin transaction.
     * @throws Commons\Sql\Exception
     */
    public function begin();
    
    /**
     * Commit transaction.
     * @throws Commons\Sql\Exception
     */
    public function commit();
    
    /**
     * Rollback transaction.
     * @throws Commons\Sql\Exception
     */
    public function rollback();
    
    /**
     * Check if driver is in transaction.
     * @return boolean
     */
    public function inTransaction();
    
}
