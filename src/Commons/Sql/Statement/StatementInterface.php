<?php

/**
 * =============================================================================
 * @file       Commons/Sql/Statement/StatementInterface.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *             Copyright (C) 2009-2013 PHP Commons Contributors
 *             All rights reserved.
 *             www.phpcommons.com
 * =============================================================================
 */

namespace Commons\Sql\Statement;

use Commons\Container\AssocContainer;
use Commons\Sql\Driver\DriverInterface;
use Commons\Sql\Sql;

interface StatementInterface
{

    /**
     * Init statement.
     * @param DriverInterface $driver
     * @param string $rawSql
     */
    public function __construct(DriverInterface $driver, $rawSql);
    
    /**
     * Bind a parameter.
     * @param string $name
     * @param mixed $value
     * @return StatementInterface
     */
    public function bind($name, $value);
    
    /**
     * Execute a statement.
     * @return StatementInterface
     */
    public function execute();
    
    /**
     * Fetch record as an entity.
     * @param string $entityClass
     * @return \Commons\Entity\Entity|null
     */
    public function fetch($entityClass = '\\Commons\\Entity\\Entity');
    
    /**
     * Fetch all records as a collection of entities.
     * @param string $entityClass
     * @return \Commons\Entity\Collection
     */
    public function fetchCollection($entityClass = '\\Commons\\Entity\\Entity');
    
    /**
     * Fetch all rows as array.
     * @return array
     */
    public function fetchArray();
    
    /**
     * Fetch a single column value from the last record.
     * @param string $name
     * @return mixed|null
     */
    public function fetchScalar($index = 0);
    
}
