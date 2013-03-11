<?php

/**
 * =============================================================================
 * @file        Commons/Sql/Dao/AbstractDao.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *              Copyright (C) 2009-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

namespace Commons\Sql\Dao;

use Commons\Sql\Query;

abstract class AbstractDao
{
    
    protected $_connection;
    
    /**
     * Setup a DAO object.
     * @param Commons\Sql\Connection $connection
     */
    public function __construct(Connection $connection)
    {
        $this->_connection = $connection;
    }
    
    /**
     * Get database connection.
     * @return Commons\Sql\Connection
     */
    public function getConnection()
    {
        return $this->_connection;
    }
    
    /**
     * Create a new query.
     * @return Commons\Sql\Query
     */
    public function createQuery()
    {
        return new Query($this->getConnection());
    }
    
    /**
     * Find a record by id.
     * @note A record needs to have an 'id' field!
     * @param int $id
     * @throws Commons\Exception\NotImplementedException
     * @return Commons\Sql\Record
     */
    public function find($id)
    {
        throw new NotImplementedException();
    }
    
    /**
     * Find all records.
     * @throws Commons\Exception\NotImplementedException
     * @return array
     */
    public function findAll()
    {
        throw new NotImplementedException();
    }
    
    /**
     * Insert or update a record.
     * @note A record needs to have an 'id' field!
     * @param Commons\Sql\Record $record
     * @throws Commons\Exception\NotImplementedException
     * @return Commons\Sql\Dao\AbstractDao
     */
    public function save(Record $record)
    {
        throw new NotImplementedException();
    }
    
    /**
     * Delete a record.
     * @note A record needs to have an 'id' field!
     * @param Commons\Sql\Record $record
     * @throws Commons\Exception\NotImplementedException
     * @return Commons\Sql\Dao\AbstractDao
     */
    public function delete(Record $record)
    {
        throw new NotImplementedException();
    }
    
}
