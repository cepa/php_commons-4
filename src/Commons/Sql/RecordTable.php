<?php

/**
 * =============================================================================
 * @file        Commons/Sql/RecordTable.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *              Copyright (C) 2009-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

namespace Commons\Sql;

use Commons\Exception\InvalidArgumentException;
use Commons\Exception\NotImplementedException;
use Commons\Sql\Connection\ConnectionInterface;
use Commons\Sql\Dao\AbstractDao;
use Commons\Sql\Driver\PdoDriver;
use Commons\Sql\Sql;

class RecordTable extends AbstractDao
{
    
    protected $_tableName;
    protected $_connection;
    protected $_modelName = '\\Commons\\Sql\\Record';
    protected $_primaryKey = 'id';
    
    /**
     * Init table.
     * @param Commons\Sql\Connection\ConnectionInterface $connection
     */
    public function __construct(ConnectionInterface $connection)
    {
        $this->_connection = $connection;
    }
    
    /**
     * Set table name.
     * @param string $tableName
     * @return Commons\Sql\RecordTable
     */
    public function setTableName($tableName)
    {
        $this->_tableName = $tableName;
        return $this;
    }
    
    /**
     * Get table name.
     * @return string
     */
    public function getTableName()
    {
        return $this->_tableName;
    }
    
    /**
     * Get connection.
     * @return ConnectionInterface
     */
    public function getConnection()
    {
        return $this->_connection;
    }
    
    /**
     * Set model name.
     * @param string $modelName
     * @return Commons\Sql\RecordTable
     */
    public function setModelName($modelName)
    {
        $this->_modelName = $modelName;
        return $this;
    }
    
    /**
     * Get model name.
     * @return string
     */
    public function getModelName()
    {
        return $this->_modelName;
    }
    
    /**
     * Set primary key.
     * @param string $primaryKey
     * @return \Commons\Sql\RecordTable
     */
    public function setPrimaryKey($primaryKey)
    {
        $this->_primaryKey = $primaryKey;
        return $this;
    }
    
    /**
     * Get primary key.
     * @return string
     */
    public function getPrimaryKey()
    {
        return $this->_primaryKey;
    }
    
    /**
     * Create a query instance.
     * @see Commons\Sql\Dao\AbstractDao::createQuery()
     * @return Commons\Sql\RecordTable
     */
    public function createQuery()
    {
        return parent::createQuery()->setObjectClassName($this->getModelName());
    }
    
    /**
     * Create a record instance.
     * @throws InvalidArgumentException
     * @return \Commons\Sql\Record
     */
    public function createRecord()
    {
        $className = $this->getModelName();
        $record = new $className();
        if (!($record instanceof Record)) {
            throw new InvalidArgumentException("Invalid record class '{$className}'");
        }
        $record
            ->setConnection($this->getConnection())
            ->setTable($this);
        return $record;
    }
    
    /**
     * Find by id.
     * @see Commons\Sql\Dao\AbstractDao::find()
     * @return Commons\Sql\Record
     */
    public function find($id)
    {
        return $this->createQuery()
            ->select("*")
            ->from($this->getTableName())
            ->where($this->getPrimaryKey()." = ?", $id)
            ->execute()
            ->fetchObject();
    }
    
    /**
     * Find all records.
     * @see Commons\Sql\Dao\AbstractDao::findAll()
     * @return array
     */
    public function findAll()
    {
        return $this->createQuery()
            ->select('*')
            ->from($this->getTableName())
            ->execute()
            ->fetchAllObjects();
    }
    
    /**
     * Save record.
     * @see Commons\Sql\Dao\AbstractDao::save()
     * @return Commons\Sql\RecordTable
     */
    public function save(Record $record)
    {
        $primaryKey = $this->getPrimaryKey();
        $isNewRecord = ($record->has($primaryKey) ? false : true);
        
        if ($isNewRecord) {
            $record->preInsert();
        } else {
            $record->preUpdate();
        }
        
        $query = $this->createQuery();
        
        if (!$isNewRecord) {
            $query
                ->update($this->getTableName())
                ->where($primaryKey.' = ?', $record->get($primaryKey));
        } else {
            $query->insertInto($this->getTableName());
        }
        
        foreach ($record as $name => $value) {
            $query->set($name, $value);
        }
        
        $query->execute();
        
        if ($isNewRecord) {
            $databaseType = $this->getConnection()->getDatabaseType();
            switch ($databaseType) {
                case Sql::TYPE_MYSQL:
                    $id = $this->createQuery()
                        ->select("LAST_INSERT_ID()")
                        ->execute()
                        ->fetchColumn();
                    $record->set($primaryKey, $id);
                    break;
                            
                case Sql::TYPE_POSTGRESQL:
                    $id = $this->createQuery()
                        ->select("CURRVAL('{$this->getTableName()}_{$primaryKey}_seq')")
                        ->execute()
                        ->fetchColumn();
                    $record->set($primaryKey, $id);
                    break;
                            
                default: throw new NotImplementedException("Unsupported driver '{$databaseType}'!");
            }
        }
        
        if ($isNewRecord) {
            $record->postInsert();
        } else {
            $record->postUpdate();
        }
        
        return $this;
    }
    
    /**
     * Delete record.
     * @see Commons\Sql\Dao\AbstractDao::delete()
     * @return Commons\Sql\RecordTable
     */
    public function delete(Record $record)
    {
        $primaryKey = $this->getPrimaryKey();
        $record->preDelete();
        
        if (!$record->has($primaryKey)) {
            throw new InvalidArgumentException("Record doesnt have '{$primaryKey}' field!");
        }
        $this->createQuery()
            ->delete($this->_tableName)
            ->where($primaryKey." = ?", (int) $record->get($primaryKey))
            ->execute();
        
        $record->postDelete();
        
        return $this;
    }
    
}
