<?php

/**
 * =============================================================================
 * @file        Commons/Sql/Record.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *              Copyright (C) 2009-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

namespace Commons\Sql;

use Commons\Container\AssocContainer;
use Commons\Sql\Connection\ConnectionInterface;

class Record extends AssocContainer
{
    
    protected $_connection;
    protected $_table;
    
    /**
     * Set connection.
     * @param Commons\Sql\Connection\ConnectionInterface $connection
     * @return Commons\Sql\Record
     */
    public function setConnection(ConnectionInterface $connection)
    {
        $this->_connection = $connection;
        return $this;
    }
    
    /**
     * Get connection.
     * @throws Commons\Sql\Exception
     * @return Commons\Sql\Connection\ConnectionInterface
     */
    public function getConnection()
    {
        if (!isset($this->_connection)) {
            throw new Exception("There is no connection assigned to this record!");
        }
        return $this->_connection;
    }
    
    /**
     * Create query.
     * @return Commons\Sql\Query
     */
    public function createQuery()
    {
        return $this->getConnection()->createQuery();
    }
    
    /**
     * Set table.
     * @param \Commons\Sql\RecordTable $table
     * @return \Commons\Sql\Record
     */
    public function setTable(RecordTable $table)
    {
        $this->_table = $table;
        return $this;
    }
    
    /**
     * Get table.
     * @param string $recordName
     * @return Commons\Sql\RecordTable
     */
    public function getTable($recordName = null)
    {
        if (isset($recordName)) {
            return $this->getConnection()->getTable($recordName);
        }
        if (!isset($this->_table)) {
            $this->setTable($this->getConnection()->getTable(get_class($this)));
        }
        return $this->_table;
    }
    
    /**
     * Save record.
     * @return Commons\Sql\RecordTable
     */
    public function save()
    {
        return $this->getTable()->save($this);
    }
    
    /**
     * Delete record.
     * @return Commons\Sql\RecordTable
     */
    public function delete()
    {
        return $this->getTable()->delete($this);
    }
    
    /**
     * Find related object.
     * @param mixed $localKey
     * @param mixed $table
     * @param mixed $foreignKey
     * @return \Commons\Sql\Record|null
     */
    public function findRelated($localKey, $table, $foreignKey = 'id')
    {
        if (is_string($table)) {
            $table = $this->getConnection()->getTable($table);
        }
        return $table->createQuery()
            ->select('*')
            ->from($table->getTableName())
            ->where($foreignKey.' = '. $this->get($localKey))
            ->limit(1)
            ->execute()
            ->fetchObject();
    }
    
    /**
     * Find all related objects.
     * @param mixed $localKey
     * @param mixed $table
     * @param mixed $foreignKey
     * @return multitype:
     */
    public function findAllRelated($localKey, $table, $foreignKey = 'id')
    {
        if (is_string($table)) {
            $table = $this->getConnection()->getTable($table);
        }
        return $table->createQuery()
            ->select('*')
            ->from($table->getTableName())
            ->where($foreignKey.' = ?', $this->get($localKey))
            ->execute()
            ->fetchAllObjects();
    }

    /**
     * Hook.
     */
    public function preInsert()
    {
        
    }
    
    /**
     * Hook.
     */
    public function postInsert()
    {
        
    }
    
    /**
     * Hook.
     */
    public function preUpdate()
    {
        
    }
    
    /**
     * Hook.
     */
    public function postUpdate()
    {
        
    }
    
    /**
     * Hook.
     */
    public function preDelete()
    {
        
    }
    
    /**
     * Hook.
     */
    public function postDelete()
    {
        
    }
    
}
