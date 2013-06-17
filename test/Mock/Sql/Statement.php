<?php

/**
 * =============================================================================
 * @file       Mock/Sql/Statement.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *             Copyright (C) 2009-2013 PHP Commons Contributors
 *             All rights reserved.
 *             www.phpcommons.com
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
    
    public function fetch($entityClass = '\\Commons\\Entity\\Entity')
    {
        
    }
    
    public function fetchCollection($entityClass = '\\Commons\\Entity\\Entity')
    {
        
    }
    
    public function fetchArray()
    {
        
    }
    
    public function fetchScalar($index = 0)
    {
        
    }
    
}
