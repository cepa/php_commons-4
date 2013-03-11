<?php

/**
 * =============================================================================
 * @file        Commons/Sql/Statement/StatementInterface.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *              Copyright (C) 2009-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

namespace Commons\Sql\Statement;

use Commons\Sql\Driver\DriverInterface;
use Commons\Sql\Sql;

interface StatementInterface
{

    /**
     * Init statement.
     * @param Commons\Sql\Driver\DriverInterface $driver
     * @param string $rawSql
     */
    public function __construct(DriverInterface $driver, $rawSql);
    
    /**
     * Bind a parameter.
     * @param string $name
     * @param mixed $value
     * @return Commons\Sql\Statement\StatementInterface
     */
    public function bind($name, $value);
    
    /**
     * Execute a statement.
     * @return Commons\Sql\Statement\StatementInterface
     */
    public function execute();
    
    /**
     * Fetch the last record.
     * @param int $mode
     * @return array|Commons\Container\AssocContainer
     */
    public function fetch($mode = Sql::FETCH_ARRAY, array $options = array());
    
    /**
     * Fetch all records.
     * @param int $mode
     * @return array
     */
    public function fetchAll($mode = Sql::FETCH_ARRAY, array $options = array());
    
    /**
     * Fetch a single column value from the last record.
     * @param string $name
     * @return mixed
     */
    public function fetchColumn($name = null);
    
}
