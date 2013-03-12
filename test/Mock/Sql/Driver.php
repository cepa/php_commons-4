<?php

/**
 * =============================================================================
 * @file        Mock/Sql/Driver.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *              Copyright (C) 2009-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

namespace Mock\Sql;

use Commons\Sql\Driver\DriverInterface;
use Mock\Sql\Statement;

class Driver implements DriverInterface
{
    
    protected $_isConnected = false;
    protected $_inTransaction = false;
    protected $_numQueries = 0;
    
    public function getDatabaseType()
    {
        return 'mock';
    }
    
    public function connect($options = null)
    {
        $this->_isConnected = true;
    }
    
    public function disconnect()
    {
        $this->_isConnected = false;   
    }
    
    public function isConnected()
    {
        return $this->_isConnected;
    }
    
    public function prepareStatement($rawSql)
    {
        return new Statement($this, $rawSql);
    }
    
    public function begin()
    {
        $this->_inTransaction = true;
    }
    
    public function commit()
    {
        $this->_inTransaction = false;
    }
    
    public function rollback()
    {
        $this->_inTransaction = false;
    }
    
    public function inTransaction()
    {
        return $this->_inTransaction;
    }
    
    public function _incrementNumQueries()
    {
        $this->_numQueries++;
        return $this;
    }
    
    public function _getNumQueries()
    {
        return $this->_numQueries;
    }
    
}
