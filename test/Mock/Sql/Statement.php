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
    
    public function __construct(DriverInterface $driver, $rawSql)
    {
        
    }
    
    public function bind($name, $value)
    {
        
    }
    
    public function execute()
    {
        
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
