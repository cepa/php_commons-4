<?php

/**
 * =============================================================================
 * @file        Commons/Sql/Connection/AbstractConnection.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *              Copyright (C) 2009-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

namespace Commons\Sql\Connection;

use Commons\Sql\RecordTable;
use Commons\Sql\Query;

abstract class AbstractConnection implements ConnectionInterface
{
    
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
