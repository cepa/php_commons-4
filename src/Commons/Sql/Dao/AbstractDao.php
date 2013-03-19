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

use Commons\Exception\NotImplementedException;
use Commons\Sql\Connection\ConnectionInterface;
use Commons\Sql\Query;
use Commons\Sql\Record;

abstract class AbstractDao
{
    
    protected $_connection;

    /**
     * Setup a DAO object.
     * @param ConnectionInterface $connection
     * @internal param $
     */
    public function __construct(ConnectionInterface $connection)
    {
        $this->_connection = $connection;
    }
    
    /**
     * Get database connection.
     * @return ConnectionInterface
     */
    public function getConnection()
    {
        return $this->_connection;
    }
    
    /**
     * Create a new query.
     * @return Query
     */
    public function createQuery()
    {
        return new Query($this->getConnection());
    }
    
    /**
     * Find a record by id.
     * @note A record needs to have an 'id' field!
     * @param int $id
     * @throws NotImplementedException
     * @return Record
     */
    public function find($id)
    {
        throw new NotImplementedException();
    }
    
    /**
     * Find all records.
     * @throws NotImplementedException
     * @return array
     */
    public function findAll()
    {
        throw new NotImplementedException();
    }
    
    /**
     * Insert or update a record.
     * @note A record needs to have an 'id' field!
     * @param Record $record
     * @throws NotImplementedException
     * @return AbstractDao
     */
    public function save(Record $record)
    {
        throw new NotImplementedException();
    }
    
    /**
     * Delete a record.
     * @note A record needs to have an 'id' field!
     * @param Record $record
     * @throws NotImplementedException
     * @return AbstractDao
     */
    public function delete(Record $record)
    {
        throw new NotImplementedException();
    }
    
}
