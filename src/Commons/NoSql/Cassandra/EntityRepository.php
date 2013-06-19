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

use cassandra\NotFoundException;
use Commons\Entity\AbstractRepository;
use Commons\Entity\Collection;
use Commons\Entity\Entity;
use Commons\NoSql\Cassandra\Connection\ConnectionInterface;

class EntityRepository extends AbstractRepository
{
    
    protected $_connection;
    protected $_columnFamilyName;
    
    /**
     * Init entity repository.
     * @param ConnectionInterface $connection
     */
    public function __construct(ConnectionInterface $connection = null)
    {
        $this->_connection = $connection;
    }
    
    /**
     * Set connection.
     * @param ConnectionInterface $connection
     * @return \Commons\NoSql\Cassandra\EntityRepository
     */
    public function setConnection(ConnectionInterface $connection)
    {
        $this->_connection = $connection;
        return $this;
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
            $cf = $this->getConnection()->getColumnFamily($this->getColumnFamilyName());
            $entityClass = $this->getEntityClass();
            return new $entityClass($cf->get($primaryKey));
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
            $cf = $this->getConnection()->getColumnFamily($this->getColumnFamilyName());
            $cf->insert($entity->get($this->getPrimaryKey()), $entity->toArray());
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
            $cf = $this->getConnection()->getColumnFamily($this->getColumnFamilyName());
            $cf->remove($entity->get($this->getPrimaryKey()));
        } catch (\Exception $e) {
            throw new Exception($e);
        }
    }
    
} 
