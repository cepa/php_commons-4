<?php

/**
 * =============================================================================
 * @file        Mock/Sql/Statement.php
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
use Commons\Sql\Statement\StatementInterface;
use Commons\Sql\Sql;

class Statement implements StatementInterface
{
    
    protected $_driver;
    
    public function __construct(DriverInterface $driver, $rawSql)
    {
        $this->_driver = $driver;
    }
    
    public function bind($name, $value)
    {
        
    }
    
    public function execute()
    {
        if ($this->_driver instanceof Driver) {
            $this->_driver->_incrementNumQueries();
        }
    }
    
    public function fetch($mode = Sql::FETCH_ARRAY, array $options = array())
    {
        
    }
    
    public function fetchAll($mode = Sql::FETCH_ARRAY, array $options = array())
    {
        
    }
    
    public function fetchColumn($name = null)
    {
        
    }
    
}
