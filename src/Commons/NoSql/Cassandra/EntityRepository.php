<?php

/**
 * =============================================================================
 * @file       Commons/NoSql/Cassandra/EntityRepository.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *             Copyright (C) 2009-2013 PHP Commons Contributors
 *             All rights reserved.
 *             www.phpcommons.com
 * =============================================================================
 */

namespace Commons\NoSql\Cassandra;

use phpcassa\Connection\ConnectionPool;
use phpcassa\ColumnFamily;
use cassandra\NotFoundException;
use Commons\Entity\AbstractRepository;
use Commons\Entity\Collection;
use Commons\Entity\Entity;

class EntityRepository extends AbstractRepository
{
    
    protected $_connectionPool;
    protected $_columnFamilyName;
    private $_columnFamily;
    
    /**
     * Init cassandra repository.
     * @param ConnectionPool $cp
     */
    public function __construct(ConnectionPool $cp = null)
    {
        $this->_connectionPool = $cp;
    }
    
    /**
     * Set connection pool.
     * @param ConnectionPool $cp
     * @return \Commons\NoSql\Cassandra\EntityRepository
     */
    public function setConnectionPool(ConnectionPool $cp)
    {
        $this->_connectionPool = $cp;
        return $this;
    }
    
    /**
     * Get connection pool.
     * @return ConnectionPool
     */
    public function getConnectionPool()
    {
        return $this->_connectionPool;
    }
    
    /**
     * Set column family.
     * @param string $cfn
     * @return \Commons\NoSql\Cassandra\EntityRepository
     */
    public function setColumnFamilyName($cfn)
    {
        $this->_columnFamilyName = (string) $cfn;
        $this->_columnFamily = null;
        return $this;
    }
    
    /**
     * Get column family.
     * @return string
     */
    public function getColumnFamilyName()
    {
        return $this->_columnFamilyName;
    }
    
    public function fetch($primaryKey)
    {
        try {
            $entityClass = $this->getEntityClass();
            return new $entityClass($this->_getColumnFamily()->get($primaryKey));
        } catch (NotFoundException $e) {
            return null;
        }
    }
    
    /**
     * Not implemented.
     * @see \Commons\Entity\RepositoryInterface::fetchCollection()
     */
    public function fetchCollection($criteria = null)
    {
        throw new Exception("Not implemented");
    }
    
    /**
     * Save entity.
     * @see \Commons\Entity\RepositoryInterface::save()
     */
    public function save(Entity $entity)
    {
        try {
            $this->_getColumnFamily()->insert($entity->get($this->getPrimaryKey()), $entity->toArray());
        } catch (\Exception $e) {
            throw new Exception($e);
        }
    }
    
    /**
     * Delete entity.
     * @see \Commons\Entity\RepositoryInterface::delete()
     */
    public function delete(Entity $entity)
    {
        try {
            $this->_getColumnFamily()->remove($entity->get($this->getPrimaryKey()));
        } catch (\Exception $e) {
            throw new Exception($e);
        }
    }
    
    /**
     * Get or create column family instance.
     * @return \phpcassa\ColumnFamily
     */
    protected function _getColumnFamily()
    {
        if (!isset($this->_columnFamily)) {
            $this->_columnFamily = new ColumnFamily(
                $this->getConnectionPool(),
                $this->getColumnFamilyName());
        }
        return $this->_columnFamily;
    }
    
} 
